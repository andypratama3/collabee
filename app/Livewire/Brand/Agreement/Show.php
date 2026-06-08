<?php

namespace App\Livewire\Brand\Agreement;

use App\Models\Agreement;
use App\Services\Campaign\AgreementService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Agreement $agreement;

    public function mount(Agreement $agreement): void
    {
        $this->authorize('view', $agreement);
        $agreement->load('hiring.campaign.brandProfile.user', 'hiring.kolProfile.user', 'payment');
        $this->agreement = $agreement;
    }

    public function render()
    {
        return view('livewire.brand.agreement.show', [
            'agreement' => $this->agreement,
        ])->layout('layouts.app');
    }

    public function sign(AgreementService $agreementService): void
    {
        $this->authorize('sign', $this->agreement);

        try {
            $agreementService->signAsBrand($this->agreement);
            $this->agreement->refresh()->load('hiring.campaign.brandProfile.user', 'hiring.kolProfile.user', 'payment');

            // If fully signed, redirect to payment page
            if ($this->agreement->status === 'signed') {
                session()->flash('success', 'Agreement telah ditandatangani oleh kedua pihak. Silakan lakukan pembayaran.');
                $this->redirect(route('brand.payment.index'), navigate: true);
                return;
            }

            session()->flash('success', 'Agreement berhasil ditandatangani. Menunggu tanda tangan KOL.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function downloadPdf(AgreementService $agreementService): mixed
    {
        $this->authorize('view', $this->agreement);

        if (!$this->agreement->pdf_path) {
            // Generate PDF on demand if not exists
            $agreementService->generatePdf($this->agreement);
            $this->agreement->refresh();
        }

        return $this->redirect($agreementService->getPdfUrl($this->agreement));
    }
}
