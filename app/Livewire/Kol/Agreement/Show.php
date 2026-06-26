<?php

namespace App\Livewire\Kol\Agreement;

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
        return view('livewire.kol.agreement.show', [
            'agreement' => $this->agreement,
        ])->layout('layouts.app');
    }

    public function sign(AgreementService $agreementService): void
    {
        $this->authorize('sign', $this->agreement);

        try {
            $agreementService->signAsKol($this->agreement);
            $this->agreement->refresh()->load('hiring.campaign.brandProfile.user', 'hiring.kolProfile.user', 'payment');
            session()->flash('success', 'Agreement berhasil ditandatangani.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function downloadPdf(AgreementService $agreementService): mixed
    {
        $this->authorize('view', $this->agreement);

        if (! $this->agreement->pdf_path) {
            $agreementService->generatePdf($this->agreement);
            $this->agreement->refresh();
        }

        return $this->redirect($agreementService->getPdfUrl($this->agreement));
    }
}
