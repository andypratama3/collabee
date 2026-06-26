<?php

namespace App\Livewire\Brand\Profile;

use App\Models\BrandProfile;
use App\Services\Brand\BrandProfileService;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public BrandProfile $profile;

    public string $brand_name = '';

    public string $description = '';

    public string $industry = '';

    public string $website = '';

    public array $target_market = [];

    public string $location = '';

    public $logo = null;

    public $banner = null;

    public string $existing_logo_url = '';

    public string $existing_banner_url = '';

    public function mount(BrandProfile $profile): void
    {
        if ($profile->user_id !== auth()->id()) {
            abort(403);
        }

        $this->profile = $profile;
        $this->brand_name = $profile->brand_name;
        $this->description = $profile->description ?? '';
        $this->industry = $profile->industry ?? '';
        $this->website = $profile->website ?? '';
        $this->target_market = $profile->target_market ?? [];
        $this->location = $profile->location ?? '';
        $this->existing_logo_url = $profile->getFirstMediaUrl('brand_logo');
        $this->existing_banner_url = $profile->getFirstMediaUrl('brand_banner');
    }

    public function update(BrandProfileService $service)
    {
        $this->validate([
            'brand_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'target_market' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
        ]);

        $service->update([
            'brand_name' => $this->brand_name,
            'description' => $this->description ?: null,
            'industry' => $this->industry ?: null,
            'website' => $this->website ?: null,
            'target_market' => ! empty($this->target_market) ? $this->target_market : null,
            'location' => $this->location ?: null,
            'logo' => $this->logo?->getRealPath(),
            'banner' => $this->banner?->getRealPath(),
        ], $this->profile);

        $this->dispatch('swal:toast', title: 'Profil Brand berhasil diperbarui.', icon: 'success');

        $this->redirect(route('brand.profile.edit', $this->profile), navigate: true);
    }

    public function render()
    {
        return view('livewire.brand.profile.edit-profile')
            ->layout('layouts.app');
    }
}
