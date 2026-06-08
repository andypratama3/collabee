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

        // Handle both Xendit invoice paid event formats:
        // Legacy: event = "paid" | New API: event = "payment.succeeded" or status = "PAID"
        $isPaidEvent = in_array($event, ['paid', 'payment.succeeded'])
            || strtoupper($payload['status'] ?? '') === 'PAID';

        // Handle disbursement webhook events
        $isDisbursementEvent = in_array($event, [
            'disbursement.completed', 'disbursement.failed',
            'DISBURSEMENT_COMPLETED', 'DISBURSEMENT_FAILED',
        ]) || in_array(strtoupper($payload['status'] ?? ''), ['COMPLETED', 'FAILED'])
            && isset($payload['external_id']) && str_starts_with($payload['external_id'] ?? '', 'WD-');

        if ($isDisbursementEvent) {
            $this->handleDisbursementWebhook($payload);
            return;
        }

        if (!$isPaidEvent) {
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

    protected function handleDisbursementWebhook(array $payload): void
    {
        $externalId = $payload['external_id'] ?? null;

        if (!$externalId || !str_starts_with($externalId, 'WD-')) {
            return;
        }

        // Extract withdrawal ID from external_id format: WD-YYYYMMDD-00001
        $parts = explode('-', $externalId);
        $withdrawalId = (int) ltrim(end($parts), '0');

        if (!$withdrawalId) {
            Log::warning('Could not parse withdrawal ID from Xendit disbursement webhook', ['external_id' => $externalId]);
            return;
        }

        $withdrawal = \App\Models\KolWithdrawal::find($withdrawalId);

        if (!$withdrawal) {
            Log::warning('Withdrawal not found for Xendit disbursement webhook', ['external_id' => $externalId]);
            return;
        }

        // Already processed — idempotency guard
        if (in_array($withdrawal->status, ['completed', 'rejected'])) {
            return;
        }

        $xenditStatus = strtoupper($payload['status'] ?? '');
        $isCompleted = in_array($xenditStatus, ['COMPLETED', 'SUCCEEDED'])
            || in_array($payload['event'] ?? '', ['disbursement.completed', 'DISBURSEMENT_COMPLETED']);

        DB::transaction(function () use ($withdrawal, $isCompleted, $payload, $externalId) {
            if ($isCompleted) {
                $withdrawal->update([
                    'status' => 'completed',
                    'processed_at' => now(),
                    'admin_note' => ($withdrawal->admin_note ?? '') . ' | Confirmed via webhook: ' . $externalId,
                ]);

                // Deduct from pending_balance — funds have now truly left the platform
                $kolProfile = $withdrawal->kolProfile;
                if ($kolProfile) {
                    $kolProfile->decrement('pending_balance', $withdrawal->amount);
                }

                Log::info('Xendit disbursement completed', ['withdrawal_id' => $withdrawal->id, 'external_id' => $externalId]);
            } else {
                // Disbursement FAILED — reverse the deduction, refund wallet
                $withdrawal->update([
                    'status' => 'failed',
                    'processed_at' => now(),
                    'admin_note' => ($withdrawal->admin_note ?? '') . ' | Disbursement FAILED via webhook: ' . ($payload['failure_code'] ?? 'UNKNOWN'),
                ]);

                $kolProfile = $withdrawal->kolProfile;
                if ($kolProfile) {
                    $kolProfile->increment('wallet_balance', $withdrawal->amount);
                    $kolProfile->decrement('pending_balance', $withdrawal->amount);
                }

                Log::warning('Xendit disbursement failed', ['withdrawal_id' => $withdrawal->id, 'external_id' => $externalId, 'failure_code' => $payload['failure_code'] ?? null]);
            }
        });
    }

    public function isValidWebhook(string $payloadBody, string $signature): bool
    {
        $webhookToken = config('xendit.webhook_token');

        if (empty($webhookToken)) {
            Log::warning('Xendit webhook token not configured');
            return false;
        }

        // Xendit uses x-callback-token header with a plain token comparison
        return hash_equals($webhookToken, $signature);
    }
}
