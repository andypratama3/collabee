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
    }

    public function render()
    {
        $this->agreement->load('hiring.campaign.brandProfile.user', 'hiring.kolProfile.user');

        return view('livewire.brand.agreement.show', [
            'agreement' => $this->agreement,
        ])->layout('layouts.app');
    }

    public function sign(AgreementService $agreementService): void
    {
        $this->authorize('sign', $this->agreement);

        try {
            $agreementService->signAsBrand($this->agreement);
            $this->agreement->refresh();
            session()->flash('success', 'Agreement signed successfully.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }
}
