<?php

namespace App\Services\Payment;

use App\Models\Agreement;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class XenditService
{
    public function __construct(
        private readonly InvoiceService $invoiceService,
        private readonly EscrowService $escrowService,
    ) {}

    public function createInvoice(Agreement $agreement, User $user): array
    {
        $payment = $this->invoiceService->createPayment($agreement);

        \Xendit\Xendit::setApiKey(config('xendit.api_key'));

        $customer = [
            'given_names' => $user->name,
            'email' => $user->email,
        ];

        $params = [
            'external_id' => $payment->invoice_number,
            'amount' => (float) $payment->total_amount,
            'description' => 'Pembayaran Campaign: ' . ($agreement->hiring->campaign->title ?? ''),
            'customer' => $customer,
            'success_redirect_url' => route('brand.payment.index'),
            'failure_redirect_url' => route('brand.payment.index'),
            'currency' => 'IDR',
        ];

        $response = \Xendit\Invoice::create($params);

        $payment->update([
            'gateway_payment_id' => $response['id'] ?? null,
            'gateway_invoice_url' => $response['invoice_url'] ?? null,
        ]);

        return $response;
    }

    public function handleWebhook(array $payload): void
    {
        $event = $payload['event'] ?? null;

        if ($event !== 'paid') {
            return;
        }

        $externalId = $payload['external_id'] ?? null;

        if (!$externalId) {
            Log::warning('Xendit webhook received without external_id');
            return;
        }

        DB::transaction(function () use ($externalId, $payload) {
            $payment = Payment::where('invoice_number', $externalId)->first();

            if (!$payment) {
                Log::warning('Payment not found for Xendit webhook', ['external_id' => $externalId]);
                return;
            }

            if ($payment->status === \App\Enums\PaymentStatus::PAID) {
                return;
            }

            $this->invoiceService->markAsPaid(
                $payment,
                $payload['id'] ?? $payload['payment_id'] ?? ''
            );

            $this->escrowService->holdFunds($payment);
        });
    }

    public function isValidWebhook(string $payloadBody, string $signature): bool
    {
        $webhookToken = config('xendit.webhook_token');

        if (empty($webhookToken)) {
            Log::warning('Xendit webhook token not configured');
            return false;
        }

        $computedSignature = hash_hmac('sha256', $payloadBody, $webhookToken);

        return hash_equals($computedSignature, $signature);
    }
}
