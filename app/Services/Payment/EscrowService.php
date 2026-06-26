<?php

namespace App\Services\Payment;

use App\Enums\EscrowStatus;
use App\Enums\PaymentStatus;
use App\Models\EscrowTransaction;
use App\Models\Payment;
use App\Services\Notification\NotificationService;
use Illuminate\Support\Facades\DB;

class EscrowService
{
    public function __construct(
        private readonly NotificationService $notificationService
    ) {}

    public function holdFunds(Payment $payment): EscrowTransaction
    {
        $escrow = DB::transaction(function () use ($payment) {
            $amount = $payment->total_amount;
            $platformFee = $payment->platform_fee;
            $kolAmount = $amount - $platformFee;

            $escrow = EscrowTransaction::create([
                'payment_id' => $payment->id,
                'amount_held' => $amount,
                'platform_fee' => $platformFee,
                'kol_amount' => $kolAmount,
                'status' => EscrowStatus::HELD,
                'held_at' => now(),
            ]);

            $payment->update(['status' => PaymentStatus::HELD]);

            return $escrow;
        });

        $this->notificationService->send(
            $payment->agreement->hiring->kolProfile->user,
            'payment',
            'Pembayaran diterima',
            'Pembayaran untuk campaign sebesar Rp '.number_format($payment->amount, 0, ',', '.').' telah diterima dan dana diamankan di escrow.',
            ['payment' => $payment],
            route('kol.dashboard')
        );

        return $escrow;
    }

    public function releaseEscrow(EscrowTransaction $escrow, string $trigger = 'content_approved'): void
    {
        // Idempotency guard — prevent double release
        if ($escrow->status === EscrowStatus::RELEASED) {
            return;
        }

        DB::transaction(function () use ($escrow, $trigger) {
            $escrow->update([
                'status' => EscrowStatus::RELEASED,
                'release_trigger' => $trigger,
                'released_at' => now(),
            ]);

            $kolProfile = $escrow->payment->agreement->hiring->kolProfile;
            $kolProfile->increment('wallet_balance', $escrow->kol_amount);
            $kolProfile->increment('total_earned', $escrow->kol_amount);
            $kolProfile->increment('total_campaigns_done');

            $escrow->payment->update(['status' => PaymentStatus::RELEASED]);
        });

        $this->notificationService->send(
            $escrow->payment->agreement->hiring->kolProfile->user,
            'payment',
            'Dana escrow dirilis',
            'Dana sebesar Rp '.number_format($escrow->kol_amount, 0, ',', '.').' telah dirilis ke wallet Anda.',
            ['payment' => $escrow->payment],
            route('kol.dashboard')
        );
    }

    public function autoReleaseEscrow(): void
    {
        $escrows = EscrowTransaction::where('status', EscrowStatus::HELD)
            ->where('held_at', '<=', now()->subDays(7))
            ->whereHas('payment.agreement.contents', function ($query) {
                $query->whereIn('status', ['approved', 'completed']);
            })
            ->get();

        foreach ($escrows as $escrow) {
            $this->releaseEscrow($escrow, 'auto_release');
        }
    }

    public function refundEscrow(EscrowTransaction $escrow): void
    {
        DB::transaction(function () use ($escrow) {
            $escrow->update([
                'status' => EscrowStatus::REFUNDED,
            ]);

            $escrow->payment->update(['status' => PaymentStatus::REFUNDED]);
        });
    }
}
