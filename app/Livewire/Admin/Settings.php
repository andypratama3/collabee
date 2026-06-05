<?php

namespace App\Livewire\Admin;

use App\Models\AppSetting;
use Livewire\Component;

class Settings extends Component
{
    public string $platformFeePercent = '';
    public string $minWithdrawal = '';
    public string $maxWithdrawal = '';
    public string $contactEmail = '';
    public string $aboutText = '';
    public string $termsText = '';
    public string $privacyText = '';
    public bool $maintenanceMode = false;

    public function mount(): void
    {
        $this->platformFeePercent = $this->getSetting('platform_fee_percent', '10');
        $this->minWithdrawal = $this->getSetting('min_withdrawal', '50000');
        $this->maxWithdrawal = $this->getSetting('max_withdrawal', '50000000');
        $this->contactEmail = $this->getSetting('contact_email', config('mail.from.address'));
        $this->aboutText = $this->getSetting('about_text', '');
        $this->termsText = $this->getSetting('terms_text', '');
        $this->privacyText = $this->getSetting('privacy_text', '');
        $this->maintenanceMode = (bool) $this->getSetting('maintenance_mode', 'false');
    }

    private function getSetting(string $key, string $default = ''): string
    {
        $setting = AppSetting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    private function saveSetting(string $key, string|int $value, string $group = 'general', string $type = 'string'): void
    {
        AppSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => (string) $value,
                'group' => $group,
                'type' => $type,
            ]
        );
    }

    public function save(): void
    {
        $this->validate([
            'platformFeePercent' => 'required|numeric|min:0|max:100',
            'minWithdrawal' => 'required|numeric|min:0',
            'maxWithdrawal' => 'required|numeric|min:0',
            'contactEmail' => 'required|email',
        ]);

        $this->saveSetting('platform_fee_percent', $this->platformFeePercent, 'payment', 'number');
        $this->saveSetting('min_withdrawal', $this->minWithdrawal, 'payment', 'number');
        $this->saveSetting('max_withdrawal', $this->maxWithdrawal, 'payment', 'number');
        $this->saveSetting('contact_email', $this->contactEmail, 'general', 'email');
        $this->saveSetting('about_text', $this->aboutText, 'content', 'textarea');
        $this->saveSetting('terms_text', $this->termsText, 'content', 'textarea');
        $this->saveSetting('privacy_text', $this->privacyText, 'content', 'textarea');
        $this->saveSetting('maintenance_mode', $this->maintenanceMode ? 'true' : 'false', 'general', 'boolean');

        session()->flash('success', 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        return view('admin.settings')->layout('layouts.app');
    }
}
