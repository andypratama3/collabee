<?php

namespace App\Livewire\Brand\Profile;

use App\Models\User;
use App\Services\Brand\BrandProfileService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class CreateProfile extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $brand_name = '';

    #[Validate('nullable|string|max:1000')]
    public string $description = '';

    #[Validate('nullable|string|max:255')]
    public string $industry = '';

    #[Validate('nullable|url|max:255')]
    public string $website = '';

    #[Validate('nullable|array')]
    public array $target_market = [];

    #[Validate('nullable|string|max:255')]
    public string $location = '';

    #[Validate('nullable|image|max:2048')]
    public $logo = null;

    #[Validate('nullable|image|max:2048')]
    public $banner = null;

    public function save(BrandProfileService $service)
    {
        $this->validate();

        $profile = $service->create([
            'brand_name' => $this->brand_name,
            'description' => $this->description ?: null,
            'industry' => $this->industry ?: null,
            'website' => $this->website ?: null,
            'target_market' => !empty($this->target_market) ? $this->target_market : null,
            'location' => $this->location ?: null,
            'logo' => $this->logo?->getRealPath(),
            'banner' => $this->banner?->getRealPath(),
        ], auth()->user());

        session()->flash('success', 'Profil Brand berhasil dibuat.');

        return $this->redirect(route('brand.profile.edit', $profile), navigate: true);
    }

    public function render()
    {
        return view('livewire.brand.profile.create-profile')
            ->layout('layouts.app');
    }
}
