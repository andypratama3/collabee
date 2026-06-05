<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'platform_name', 'value' => 'Collabee', 'group' => 'general', 'type' => 'string', 'description' => 'Nama platform'],
            ['key' => 'platform_tagline', 'value' => 'Connecting Brands with KOLs', 'group' => 'general', 'type' => 'string', 'description' => 'Tagline platform'],
            ['key' => 'platform_logo', 'value' => null, 'group' => 'general', 'type' => 'string', 'description' => 'Logo URL'],
            ['key' => 'platform_favicon', 'value' => null, 'group' => 'general', 'type' => 'string', 'description' => 'Favicon URL'],
            ['key' => 'platform_email', 'value' => 'hello@collabee.id', 'group' => 'general', 'type' => 'string', 'description' => 'Email kontak platform'],
            ['key' => 'platform_phone', 'value' => null, 'group' => 'general', 'type' => 'string', 'description' => 'Nomor telepon platform'],
            ['key' => 'platform_address', 'value' => null, 'group' => 'general', 'type' => 'text', 'description' => 'Alamat kantor'],

            ['key' => 'platform_fee_percent', 'value' => '5.00', 'group' => 'payment', 'type' => 'decimal', 'description' => 'Persentase fee platform dari transaksi'],
            ['key' => 'min_withdrawal_amount', 'value' => '100000', 'group' => 'payment', 'type' => 'integer', 'description' => 'Minimal penarikan dana KOL'],
            ['key' => 'max_withdrawal_amount', 'value' => '50000000', 'group' => 'payment', 'type' => 'integer', 'description' => 'Maksimal penarikan dana KOL'],
            ['key' => 'withdrawal_admin_fee', 'value' => '5000', 'group' => 'payment', 'type' => 'integer', 'description' => 'Biaya admin penarikan'],
            ['key' => 'xendit_mode', 'value' => 'sandbox', 'group' => 'payment', 'type' => 'string', 'description' => 'Mode Xendit (sandbox/production)'],

            ['key' => 'auto_release_days', 'value' => '7', 'group' => 'escrow', 'type' => 'integer', 'description' => 'Auto-release escrow setelah N hari tanpa review'],
            ['key' => 'hiring_expiry_hours', 'value' => '48', 'group' => 'escrow', 'type' => 'integer', 'description' => 'Masa berlaku undangan hiring (jam)'],

            ['key' => 'max_revision_count', 'value' => '3', 'group' => 'content', 'type' => 'integer', 'description' => 'Maksimal revisi konten'],
            ['key' => 'content_deadline_days', 'value' => '14', 'group' => 'content', 'type' => 'integer', 'description' => 'Batas waktu pengumpulan konten'],

            ['key' => 'maintenance_mode', 'value' => 'false', 'group' => 'system', 'type' => 'boolean', 'description' => 'Mode maintenance'],
            ['key' => 'registration_open', 'value' => 'true', 'group' => 'system', 'type' => 'boolean', 'description' => 'Pendaftaran terbuka'],
            ['key' => 'max_file_upload_size', 'value' => '10', 'group' => 'system', 'type' => 'integer', 'description' => 'Max upload file (MB)'],
            ['key' => 'allowed_file_types', 'value' => 'jpg,jpeg,png,gif,webp,mp4,mov,pdf,doc,docx', 'group' => 'system', 'type' => 'string', 'description' => 'Tipe file yang diizinkan'],
        ];

        foreach ($settings as $setting) {
            AppSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
