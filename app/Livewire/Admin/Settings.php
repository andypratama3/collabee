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
        // Fetch all settings in a single query to avoid N+1
        $settings = AppSetting::pluck('value', 'key');

        $this->platformFeePercent = (string) ($settings['platform_fee_percent'] ?? '10');
        $this->minWithdrawal = (string) ($settings['min_withdrawal'] ?? '50000');
        $this->maxWithdrawal = (string) ($settings['max_withdrawal'] ?? '50000000');
        $this->contactEmail = (string) ($settings['contact_email'] ?? config('mail.from.address'));
        $this->aboutText = (string) ($settings['about_text'] ?? '');
        $this->termsText = (string) ($settings['terms_text'] ?? '');
        $this->privacyText = (string) ($settings['privacy_text'] ?? '');
        $this->maintenanceMode = ($settings['maintenance_mode'] ?? 'false') === 'true';
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
