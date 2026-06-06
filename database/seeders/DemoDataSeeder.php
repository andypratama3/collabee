<?php

namespace Database\Seeders;

use App\Enums\CampaignStatus;
use App\Enums\HiringStatus;
use App\Models\Agreement;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Hiring;
use App\Models\KolBankAccount;
use App\Models\KolProfile;
use App\Models\KolSocialAccount;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::factory()->superAdmin()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@collabee.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $superAdmin->assignRole('super_admin');

        $admin = User::factory()->admin()->create([
            'name' => 'Admin Collabee',
            'email' => 'admin@collabee.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $admin->assignRole('admin');

        $brandUser1 = User::factory()->brand()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@sepatuku.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $brandUser1->assignRole('brand');

        $brandProfile1 = BrandProfile::factory()->create([
            'user_id' => $brandUser1->id,
            'brand_name' => 'SepatuKu',
            'industry' => 'fashion',
            'description' => 'Brand sepatu lokal Indonesia dengan desain modern dan material berkualitas.',
            'location' => 'Jakarta',
            'total_campaigns' => 3,
            'rating_avg' => 4.5,
            'rating_count' => 12,
            'profile_completed_at' => now(),
        ]);

        $brandUser2 = User::factory()->brand()->create([
            'name' => 'Siti Rahmawati',
            'email' => 'siti@warungrasa.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $brandUser2->assignRole('brand');

        $brandProfile2 = BrandProfile::factory()->create([
            'user_id' => $brandUser2->id,
            'brand_name' => 'WarungRasa',
            'industry' => 'food',
            'description' => 'Katering dan makanan siap saji berbahan organik dari petani lokal Indonesia.',
            'location' => 'Bandung',
            'total_campaigns' => 2,
            'rating_avg' => 4.2,
            'rating_count' => 8,
            'profile_completed_at' => now(),
        ]);

        $kolUser1 = User::factory()->kol()->create([
            'name' => 'Ayu Putri',
            'email' => 'ayu@example.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $kolUser1->assignRole('kol');

        $kolProfile1 = KolProfile::factory()->create([
            'user_id' => $kolUser1->id,
            'display_name' => 'Ayu Putri',
            'bio' => 'Fashion & lifestyle enthusiast | 25 | Jakarta | DM for collab',
            'category' => 'fashion',
            'location' => 'Jakarta',
            'gender' => 'female',
            'total_followers' => 45000,
            'avg_engagement_rate' => 4.5,
            'total_campaigns_done' => 15,
            'total_earned' => 25000000,
            'wallet_balance' => 5000000,
            'pending_balance' => 2000000,
            'rating_avg' => 4.7,
            'rating_count' => 10,
            'is_open_for_work' => true,
            'min_budget' => 500000,
            'profile_completed_at' => now(),
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile1->id,
            'platform' => 'instagram',
            'username' => 'ayupuri',
            'profile_url' => 'https://instagram.com/ayupuri',
            'followers_count' => 45000,
            'engagement_rate' => 4.5,
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile1->id,
            'platform' => 'tiktok',
            'username' => 'ayupuri',
            'profile_url' => 'https://tiktok.com/@ayupuri',
            'followers_count' => 28000,
            'engagement_rate' => 5.2,
        ]);

        $kolUser2 = User::factory()->kol()->create([
            'name' => 'Rizky Ramadhan',
            'email' => 'rizky@example.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $kolUser2->assignRole('kol');

        $kolProfile2 = KolProfile::factory()->create([
            'user_id' => $kolUser2->id,
            'display_name' => 'Rizky Ramadhan',
            'bio' => 'Tech reviewer & content creator | Gadget | Gaming | Apps',
            'category' => 'tech',
            'location' => 'Yogyakarta',
            'gender' => 'male',
            'total_followers' => 82000,
            'avg_engagement_rate' => 3.8,
            'total_campaigns_done' => 25,
            'total_earned' => 45000000,
            'wallet_balance' => 8000000,
            'pending_balance' => 3000000,
            'rating_avg' => 4.5,
            'rating_count' => 20,
            'is_open_for_work' => true,
            'min_budget' => 1000000,
            'profile_completed_at' => now(),
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile2->id,
            'platform' => 'youtube',
            'username' => 'RizkyRamadhanTech',
            'profile_url' => 'https://youtube.com/@RizkyRamadhanTech',
            'followers_count' => 82000,
            'engagement_rate' => 3.8,
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile2->id,
            'platform' => 'instagram',
            'username' => 'rizkyramadhan',
            'profile_url' => 'https://instagram.com/rizkyramadhan',
            'followers_count' => 35000,
            'engagement_rate' => 2.5,
        ]);

        KolBankAccount::create([
            'kol_profile_id' => $kolProfile1->id,
            'bank_name' => 'Bank Central Asia',
            'account_number' => '1234567890',
            'account_name' => 'Ayu Putri',
        ]);

        KolBankAccount::create([
            'kol_profile_id' => $kolProfile2->id,
            'bank_name' => 'Bank Mandiri',
            'account_number' => '0987654321',
            'account_name' => 'Rizky Ramadhan',
        ]);

        $campaign1 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile1->id,
            'title' => 'Road to Lebaran 2025 - Koleksi Sepatu Terbaru',
            'status' => CampaignStatus::OPEN,
            'budget_total' => 25000000,
            'budget_per_kol' => 2500000,
            'kol_slots' => 5,
            'kol_filled' => 2,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(37),
            'deadline_apply' => now()->addDays(5),
            'is_featured' => true,
        ]);

        $campaign2 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile1->id,
            'title' => 'SepatuKu x Content Creator - Daily Style Challenge',
            'status' => CampaignStatus::IN_PROGRESS,
            'budget_total' => 15000000,
            'budget_per_kol' => 1500000,
            'kol_slots' => 3,
            'kol_filled' => 2,
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(25),
            'deadline_apply' => now()->subDays(2),
        ]);

        $campaign3 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile2->id,
            'title' => 'WarungRasa - Catering Sehat untuk Kantor',
            'status' => CampaignStatus::OPEN,
            'budget_total' => 10000000,
            'budget_per_kol' => 1000000,
            'kol_slots' => 3,
            'kol_filled' => 0,
            'start_date' => now()->addDays(14),
            'end_date' => now()->addDays(44),
            'deadline_apply' => now()->addDays(10),
            'kol_category' => 'food',
            'is_featured' => true,
        ]);

        $hiring1 = Hiring::factory()->create([
            'campaign_id' => $campaign2->id,
            'brand_profile_id' => $brandProfile1->id,
            'kol_profile_id' => $kolProfile1->id,
            'initiated_by' => 'brand',
            'status' => HiringStatus::ACCEPTED,
            'proposed_budget' => 1500000,
            'agreed_budget' => 1500000,
            'message' => 'Hai Ayu! Kami tertarik untuk mengajak kamu berkolaborasi di campaign Daily Style Challenge.',
            'accepted_at' => now()->subDays(3),
            'expires_at' => now()->addDays(4),
        ]);

        $hiring2 = Hiring::factory()->create([
            'campaign_id' => $campaign2->id,
            'brand_profile_id' => $brandProfile1->id,
            'kol_profile_id' => $kolProfile2->id,
            'initiated_by' => 'brand',
            'status' => HiringStatus::NEGOTIATING,
            'proposed_budget' => 2000000,
            'message' => 'Hai Rizky! Kami ingin kamu menjadi bagian dari campaign Daily Style Challenge. Mohon konfirmasi budget yang diinginkan.',
            'expires_at' => now()->addDays(5),
        ]);

        $hiring3 = Hiring::factory()->create([
            'campaign_id' => $campaign1->id,
            'brand_profile_id' => $brandProfile1->id,
            'kol_profile_id' => $kolProfile1->id,
            'initiated_by' => 'brand',
            'status' => HiringStatus::PENDING,
            'proposed_budget' => 2500000,
            'message' => 'Ayu, kami mau ajak kamu collaborate untuk campaign Lebaran 2025!',
            'expires_at' => now()->addDays(7),
        ]);

        $agreement1 = Agreement::factory()->create([
            'hiring_id' => $hiring1->id,
            'agreement_number' => 'AGR-SPK-2025-00001',
            'total_amount' => 1500000,
            'platform_fee_percent' => 10.00,
            'status' => 'signed',
            'terms' => "1. KOL wajib membuat 3 konten Instagram (1 feed + 2 stories)\n2. Konten harus dipublikasikan dalam 7 hari setelah agreement ditandatangani\n3. KOL wajib menggunakan produk yang disediakan oleh brand\n4. Brand berhak melakukan review sebelum konten dipublikasikan",
            'brand_signed_at' => now()->subDays(3),
            'kol_signed_at' => now()->subDays(3),
            'signed_at' => now()->subDays(3),
            'expires_at' => now()->addDays(7),
        ]);

        Agreement::factory()->create([
            'hiring_id' => $hiring2->id,
            'agreement_number' => 'AGR-SPK-2025-00002',
            'total_amount' => 2000000,
            'platform_fee_percent' => 10.00,
            'status' => 'draft',
            'expires_at' => now()->addDays(7),
        ]);
    }
}
