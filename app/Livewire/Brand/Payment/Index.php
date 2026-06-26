<?php

namespace App\Livewire\Brand\Payment;

use App\Enums\PaymentStatus;
use App\Models\Agreement;
use App\Models\Payment;
use App\Services\Payment\EscrowService;
use App\Services\Payment\InvoiceService;
use App\Services\Payment\XenditService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $filter = '';

    protected $queryString = ['filter'];

    public function render()
    {
        $brandProfile = auth()->user()->brandProfile;

        if (! $brandProfile) {
            return view('livewire.brand.payment.index', [
                'payments' => collect(),
                'unpaidAgreements' => collect(),
            ])->layout('layouts.app');
        }

        $brandProfileId = $brandProfile->id;

        $payments = Payment::whereHas('agreement.hiring', function ($q) use ($brandProfileId) {
            $q->where('brand_profile_id', $brandProfileId);
        })->with('agreement.hiring.campaign', 'agreement.hiring.kolProfile.user');

        $signedAgreementsWithoutPayment = Agreement::where('status', 'signed')
            ->whereDoesntHave('payment')
            ->whereHas('hiring', function ($q) use ($brandProfileId) {
                $q->where('brand_profile_id', $brandProfileId);
            })
            ->with('hiring.campaign', 'hiring.kolProfile.user')
            ->get();

        if ($this->filter) {
            $payments->where('status', $this->filter);
        }

        return view('livewire.brand.payment.index', [
            'payments' => $payments->orderBy('created_at', 'desc')->paginate(15),
            'unpaidAgreements' => $signedAgreementsWithoutPayment,
        ])->layout('layouts.app');
    }

    public function pay(Agreement $agreement, XenditService $xenditService): void
    {
        $this->authorize('view', $agreement);

        if ($agreement->status !== 'signed') {
            session()->flash('error', 'Agreement harus ditandatangani terlebih dahulu.');

            return;
        }

        if ($agreement->payment && $agreement->payment->status === PaymentStatus::PAID) {
            session()->flash('warning', 'Pembayaran sudah dilakukan.');

            return;
        }

        try {
            $response = $xenditService->createInvoice($agreement, auth()->user());

            if (isset($response['invoice_url'])) {
                $this->redirect($response['invoice_url']);
            } else {
                session()->flash('error', 'Gagal membuat invoice pembayaran.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function simulatePay(Agreement $agreement, InvoiceService $invoiceService, EscrowService $escrowService): void
    {
        $this->authorize('view', $agreement);

        if ($agreement->status !== 'signed') {
            session()->flash('error', 'Agreement harus ditandatangani terlebih dahulu.');

            return;
        }

        if ($agreement->payment && $agreement->payment->status === PaymentStatus::PAID) {
            session()->flash('warning', 'Pembayaran sudah dilakukan.');

            return;
        }

        try {
            $payment = $invoiceService->createPayment($agreement);
            $invoiceService->markAsPaid($payment, 'SIMULATED-'.strtoupper(uniqid()));
            $escrowService->holdFunds($payment);

            session()->flash('success', 'Pembayaran berhasil disimulasikan! Dana telah diamankan di escrow.');
            $this->redirect(route('brand.payment.index'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }
}
