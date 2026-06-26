<?php

namespace App\Livewire\Admin;

use App\Enums\PaymentStatus;
use App\Exports\PaymentsExport;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class PaymentManagement extends Component
{
    use WithPagination;

    public string $statusFilter = '';

    protected $queryString = ['statusFilter'];

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function export()
    {
        return Excel::download(new PaymentsExport, 'payments-'.now()->format('Y-m-d').'.xlsx');
    }

    public function render()
    {
        $query = Payment::with(['agreement.hiring.campaign.brandProfile.user']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('admin.payments', [
            'payments' => $query->latest()->paginate(15),
            'statuses' => PaymentStatus::cases(),
        ])->layout('layouts.app');
    }
}
