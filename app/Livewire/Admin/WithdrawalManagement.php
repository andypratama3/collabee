<?php

namespace App\Livewire\Admin;

use App\Models\KolWithdrawal;
use App\Models\KolProfile;
use App\Services\Payment\DisbursementService;
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

        $this->dispatch('swal:success', title: 'Withdrawal berhasil disetujui.');
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

        $this->dispatch('swal:success', title: 'Withdrawal berhasil ditolak dan saldo dikembalikan.');
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

        $this->dispatch('swal:success', title: 'Bukti transfer berhasil diupload.');
    }

    /**
     * Disburse withdrawal directly via Xendit
     */
    public function disburseViaXendit(KolWithdrawal $withdrawal): void
    {
        if (!in_array($withdrawal->status, ['approved', 'pending'])) {
            $this->dispatch('swal:error', title: 'Withdrawal tidak dalam status yang bisa diproses.');
            return;
        }

        $disbursementService = app(DisbursementService::class);
        $result = $disbursementService->createDisbursement($withdrawal);

        if ($result['success']) {
            $this->dispatch('swal:success', title: $result['message']);
        } else {
            $this->dispatch('swal:error', title: $result['message']);
        }
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
