<?php

namespace App\Livewire\Admin;

use App\Models\KolWithdrawal;
use App\Models\KolProfile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class WithdrawalManagement extends Component
{
    use WithPagination, WithFileUploads;

    public string $statusFilter = '';
    public ?int $selectedWithdrawalId = null;
    public bool $showRejectModal = false;
    public string $rejectReason = '';
    public $proofFile = null;
    public bool $showProofModal = false;

    protected $queryString = ['statusFilter'];

    protected $rules = [
        'rejectReason' => 'required|string|min:10',
    ];

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function approve(KolWithdrawal $withdrawal): void
    {
        $withdrawal->update([
            'status' => 'approved',
            'processed_at' => now(),
        ]);

        session()->flash('success', 'Withdrawal berhasil disetujui.');
    }

    public function confirmReject(KolWithdrawal $withdrawal): void
    {
        $this->selectedWithdrawalId = $withdrawal->id;
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    public function reject(): void
    {
        $this->validate();

        $withdrawal = KolWithdrawal::findOrFail($this->selectedWithdrawalId);
        $withdrawal->update([
            'status' => 'rejected',
            'admin_note' => $this->rejectReason,
            'processed_at' => now(),
        ]);

        $profile = $withdrawal->kolProfile;
        if ($profile) {
            $profile->increment('wallet_balance', $withdrawal->amount);
        }

        $this->showRejectModal = false;
        $this->selectedWithdrawalId = null;
        $this->rejectReason = '';

        session()->flash('success', 'Withdrawal berhasil ditolak.');
    }

    public function showProofUpload(KolWithdrawal $withdrawal): void
    {
        $this->selectedWithdrawalId = $withdrawal->id;
        $this->proofFile = null;
        $this->showProofModal = true;
    }

    public function uploadProof(): void
    {
        $this->validate([
            'proofFile' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $withdrawal = KolWithdrawal::findOrFail($this->selectedWithdrawalId);

        $path = $this->proofFile->store('withdrawal-proof', 'public');
        $withdrawal->update([
            'proof_path' => $path,
            'status' => 'completed',
            'processed_at' => now(),
        ]);

        $this->showProofModal = false;
        $this->selectedWithdrawalId = null;
        $this->proofFile = null;

        session()->flash('success', 'Bukti transfer berhasil diupload.');
    }

    public function render()
    {
        $query = KolWithdrawal::with('kolProfile.user');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('admin.withdrawals', [
            'withdrawals' => $query->latest()->paginate(15),
        ])->layout('layouts.app');
    }
}
