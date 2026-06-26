<?php

namespace App\Livewire\Kol\Withdrawal;

use App\Models\KolBankAccount;
use App\Models\KolWithdrawal;
use App\Services\Payment\WithdrawalService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public float $amount = 0;

    public string $bankAccountId = '';

    public ?string $notes = null;

    protected function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:100000'],
            'bankAccountId' => ['required', 'exists:kol_bank_accounts,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected $messages = [
        'amount.required' => 'Jumlah penarikan wajib diisi.',
        'amount.numeric' => 'Jumlah penarikan harus berupa angka.',
        'amount.min' => 'Minimum penarikan adalah Rp 100.000.',
        'bankAccountId.required' => 'Pilih rekening bank tujuan.',
        'bankAccountId.exists' => 'Rekening bank tidak ditemukan.',
    ];

    public function render()
    {
        $kolProfile = auth()->user()->kolProfile;

        $bankAccounts = $kolProfile
            ? KolBankAccount::where('kol_profile_id', $kolProfile->id)->get()
            : collect();

        return view('livewire.kol.withdrawal.index', [
            'walletBalance' => $kolProfile?->wallet_balance ?? 0,
            'pendingBalance' => $kolProfile?->pending_balance ?? 0,
            'bankAccounts' => $bankAccounts,
            'withdrawals' => $kolProfile
                ? KolWithdrawal::where('kol_profile_id', $kolProfile->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(15)
                : collect(),
        ])->layout('layouts.app');
    }

    public function requestWithdrawal(WithdrawalService $withdrawalService): void
    {
        $this->validate();

        $kolProfile = auth()->user()->kolProfile;

        if (! $kolProfile) {
            session()->flash('error', 'Profil KOL tidak ditemukan.');

            return;
        }

        if ($kolProfile->wallet_balance < $this->amount) {
            session()->flash('error', 'Saldo tidak mencukupi.');

            return;
        }

        try {
            $withdrawalService->requestWithdrawal($kolProfile, $this->amount, $this->bankAccountId, $this->notes ?: null);

            session()->flash('success', 'Permintaan penarikan berhasil diajukan.');

            $this->reset(['amount', 'bankAccountId', 'notes']);
        } catch (\InvalidArgumentException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function getBankAccountProperty()
    {
        return KolBankAccount::find($this->bankAccountId);
    }
}
