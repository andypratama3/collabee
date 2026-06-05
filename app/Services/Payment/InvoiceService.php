<?php

namespace App\Services\Payment;

use App\Enums\PaymentStatus;
use App\Models\Agreement;
use App\Models\Payment;

class InvoiceService
{
    public function generateInvoiceNumber(): string
    {
        $lastPayment = Payment::where('invoice_number', 'like', 'INV-2026-%')
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = 0;
        if ($lastPayment) {
            $parts = explode('-', $lastPayment->invoice_number);
            $lastNumber = (int) end($parts);
        }

        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        return 'INV-2026-' . $newNumber;
    }

    public function createPayment(Agreement $agreement): Payment
    {
        if ($agreement->payment) {
            return $agreement->payment;
        }

        $amount = $agreement->total_amount;
        $platformFee = $amount * 0.10;

        return Payment::create([
            'agreement_id' => $agreement->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'amount' => $amount,
            'platform_fee' => $platformFee,
            'total_amount' => $amount + $platformFee,
            'gateway' => 'xendit',
            'status' => PaymentStatus::PENDING,
        ]);
    }

    public function markAsPaid(Payment $payment, string $gatewayPaymentId): Payment
    {
        $payment->update([
            'status' => PaymentStatus::PAID,
            'paid_at' => now(),
            'gateway_payment_id' => $gatewayPaymentId,
        ]);

        return $payment->fresh();
    }
}
