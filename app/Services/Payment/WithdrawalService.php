<?php

namespace App\Services\Payment;

use App\Models\KolBankAccount;
use App\Models\KolProfile;
use App\Models\KolWithdrawal;
use Illuminate\Support\Facades\DB;

class WithdrawalService
{
    public function requestWithdrawal(KolProfile $kolProfile, float $amount, string $bankAccountId, ?string $notes = null): KolWithdrawal
    {
        if ($amount < 100000) {
            throw new \InvalidArgumentException('Minimum penarikan adalah Rp 100.000');
        }

        $bankAccount = KolBankAccount::findOrFail($bankAccountId);

        if ($bankAccount->kol_profile_id !== $kolProfile->id) {
            throw new \InvalidArgumentException('Rekening bank tidak valid');
        }

        return DB::transaction(function () use ($kolProfile, $amount, $bankAccount, $notes) {
            if ($kolProfile->wallet_balance < $amount) {
                throw new \InvalidArgumentException('Saldo tidak mencukupi');
            }

            $adminFee = 0;
            $netAmount = $amount - $adminFee;

            $withdrawal = KolWithdrawal::create([
                'kol_profile_id' => $kolProfile->id,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'net_amount' => $netAmount,
                'bank_name' => $bankAccount->bank_name,
                'bank_account_number' => $bankAccount->account_number,
                'bank_account_name' => $bankAccount->account_name,
                'notes' => $notes,
                'status' => 'pending',
            ]);

            $kolProfile->decrement('wallet_balance', $amount);
            $kolProfile->increment('pending_balance', $amount);

            return $withdrawal;
        });
    }

    public function approveWithdrawal(KolWithdrawal $withdrawal): void
    {
        DB::transaction(function () use ($withdrawal) {
            $withdrawal->update([
                'status' => 'completed',
                'processed_at' => now(),
            ]);

            $kolProfile = $withdrawal->kolProfile;
            $kolProfile->decrement('pending_balance', $withdrawal->amount);
        });
    }

    public function rejectWithdrawal(KolWithdrawal $withdrawal, string $reason): void
    {
        DB::transaction(function () use ($withdrawal, $reason) {
            $withdrawal->update([
                'status' => 'rejected',
                'admin_note' => $reason,
                'processed_at' => now(),
            ]);

            $kolProfile = $withdrawal->kolProfile;
            $kolProfile->increment('wallet_balance', $withdrawal->amount);
            $kolProfile->decrement('pending_balance', $withdrawal->amount);
        });
    }
}
