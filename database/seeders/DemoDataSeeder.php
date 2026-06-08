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

        // Brand 1: Teras Dimsum Mentai
        $brandUser1 = User::factory()->brand()->create([
            'name' => 'Teras Dimsum Mentai',
            'email' => 'teras@dimsummentai.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $brandUser1->assignRole('brand');

        $brandProfile1 = BrandProfile::factory()->create([
            'user_id' => $brandUser1->id,
            'brand_name' => 'Teras Dimsum Mentai',
            'industry' => 'food',
            'description' => 'UMKM menyajikan dimsum mentai dengan cita rasa premium yang cocok untuk pecinta kuliner.',
            'location' => 'Jakarta',
            'total_campaigns' => 2,
            'rating_avg' => 4.3,
            'rating_count' => 6,
            'profile_completed_at' => now(),
        ]);

        // Brand 2: Soto Mie Bogor
        $brandUser2 = User::factory()->brand()->create([
            'name' => 'Soto Mie Bogor',
            'email' => 'soto@miebogor.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $brandUser2->assignRole('brand');

        $brandProfile2 = BrandProfile::factory()->create([
            'user_id' => $brandUser2->id,
            'brand_name' => 'Soto Mie Bogor',
            'industry' => 'food',
            'description' => 'Soto mie khas Bogor dengan kuah gurih dan topping melimpah, siap memanjakan lidah Anda.',
            'location' => 'Bogor',
            'total_campaigns' => 1,
            'rating_avg' => 4.0,
            'rating_count' => 4,
            'profile_completed_at' => now(),
        ]);

        // KOL 1: anggun
        $kolUser1 = User::factory()->kol()->create([
            'name' => 'anggun',
            'email' => 'anggun@example.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $kolUser1->assignRole('kol');

        $kolProfile1 = KolProfile::factory()->create([
            'user_id' => $kolUser1->id,
            'display_name' => 'anggun',
            'bio' => 'Mahasiswa | 23 | Fashion enthusiast | DM for collab',
            'category' => 'fashion',
            'location' => 'Jakarta',
            'gender' => 'female',
            'total_followers' => 5641,
            'avg_engagement_rate' => 4.8,
            'total_campaigns_done' => 3,
            'total_earned' => 1500000,
            'wallet_balance' => 500000,
            'pending_balance' => 200000,
            'rating_avg' => 4.5,
            'rating_count' => 3,
            'is_open_for_work' => true,
            'min_budget' => 200000,
            'profile_completed_at' => now(),
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile1->id,
            'platform' => 'instagram',
            'username' => 'anggun',
            'profile_url' => 'https://instagram.com/anggun',
            'followers_count' => 5641,
            'engagement_rate' => 4.8,
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile1->id,
            'platform' => 'tiktok',
            'username' => 'anggun',
            'profile_url' => 'https://tiktok.com/@anggun',
            'followers_count' => 3200,
            'engagement_rate' => 5.1,
        ]);

        // KOL 2: Cindi Widia
        $kolUser2 = User::factory()->kol()->create([
            'name' => 'Cindi Widia',
            'email' => 'cindi@example.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $kolUser2->assignRole('kol');

        $kolProfile2 = KolProfile::factory()->create([
            'user_id' => $kolUser2->id,
            'display_name' => 'Cindi Widia',
            'bio' => 'Mahasiswa | 25 | Beauty content creator | Skin care & makeup',
            'category' => 'beauty',
            'location' => 'Bandung',
            'gender' => 'female',
            'total_followers' => 2495,
            'avg_engagement_rate' => 5.2,
            'total_campaigns_done' => 2,
            'total_earned' => 800000,
            'wallet_balance' => 300000,
            'pending_balance' => 150000,
            'rating_avg' => 4.8,
            'rating_count' => 2,
            'is_open_for_work' => true,
            'min_budget' => 150000,
            'profile_completed_at' => now(),
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile2->id,
            'platform' => 'instagram',
            'username' => 'cindiwidia',
            'profile_url' => 'https://instagram.com/cindiwidia',
            'followers_count' => 2495,
            'engagement_rate' => 5.2,
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile2->id,
            'platform' => 'tiktok',
            'username' => 'cindiwidia',
            'profile_url' => 'https://tiktok.com/@cindiwidia',
            'followers_count' => 1800,
            'engagement_rate' => 5.8,
        ]);

        // KOL 3: Tata
        $kolUser3 = User::factory()->kol()->create([
            'name' => 'Tata',
            'email' => 'tata@example.test',
            'password' => Hash::make('password'),
            'is_verified' => true,
        ]);
        $kolUser3->assignRole('kol');

        $kolProfile3 = KolProfile::factory()->create([
            'user_id' => $kolUser3->id,
            'display_name' => 'Tata',
            'bio' => 'Freelance | 27 | Food reviewer | Makan enak murah meriah',
            'category' => 'food',
            'location' => 'Jakarta',
            'gender' => 'female',
            'total_followers' => 1217,
            'avg_engagement_rate' => 6.1,
            'total_campaigns_done' => 1,
            'total_earned' => 300000,
            'wallet_balance' => 100000,
            'pending_balance' => 50000,
            'rating_avg' => 5.0,
            'rating_count' => 1,
            'is_open_for_work' => true,
            'min_budget' => 100000,
            'profile_completed_at' => now(),
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile3->id,
            'platform' => 'instagram',
            'username' => 'tatafood',
            'profile_url' => 'https://instagram.com/tatafood',
            'followers_count' => 1217,
            'engagement_rate' => 6.1,
        ]);

        KolSocialAccount::create([
            'kol_profile_id' => $kolProfile3->id,
            'platform' => 'tiktok',
            'username' => 'tatafood',
            'profile_url' => 'https://tiktok.com/@tatafood',
            'followers_count' => 900,
            'engagement_rate' => 7.2,
        ]);

        KolBankAccount::create([
            'kol_profile_id' => $kolProfile1->id,
            'bank_name' => 'Bank Central Asia',
            'account_number' => '1234567890',
            'account_name' => 'Anggun',
        ]);

        KolBankAccount::create([
            'kol_profile_id' => $kolProfile2->id,
            'bank_name' => 'Bank Mandiri',
            'account_number' => '0987654321',
            'account_name' => 'Cindi Widia',
        ]);

        KolBankAccount::create([
            'kol_profile_id' => $kolProfile3->id,
            'bank_name' => 'Bank Rakyat Indonesia',
            'account_number' => '1122334455',
            'account_name' => 'Tata',
        ]);

        // Campaign Teras Dimsum Mentai
        $campaign1 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile1->id,
            'title' => 'Teras Dimsum Mentai - Food Review by Nano Influencer',
            'status' => CampaignStatus::OPEN,
            'budget_total' => 5000000,
            'budget_per_kol' => 500000,
            'kol_slots' => 5,
            'kol_filled' => 0,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(37),
            'deadline_apply' => now()->addDays(5),
            'kol_category' => 'food',
            'is_featured' => true,
        ]);

        $campaign2 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile1->id,
            'title' => 'Review Menu Terbaru Teras Dimsum Mentai',
            'status' => CampaignStatus::OPEN,
            'budget_total' => 3000000,
            'budget_per_kol' => 300000,
            'kol_slots' => 3,
            'kol_filled' => 1,
            'start_date' => now()->addDays(14),
            'end_date' => now()->addDays(44),
            'deadline_apply' => now()->addDays(10),
            'kol_category' => 'food',
        ]);

        // Campaign Soto Mie Bogor
        $campaign3 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile2->id,
            'title' => 'Soto Mie Bogor - Endorsement Nano Influencer Kuliner',
            'status' => CampaignStatus::OPEN,
            'budget_total' => 3000000,
            'budget_per_kol' => 300000,
            'kol_slots' => 4,
            'kol_filled' => 0,
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(40),
            'deadline_apply' => now()->addDays(7),
            'kol_category' => 'food',
            'is_featured' => true,
        ]);

        // Campaign Khusus untuk KOL
        $campaign4 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile1->id,
            'title' => 'Teras Dimsum Mentai - Fashionable Food Campaign',
            'status' => CampaignStatus::OPEN,
            'budget_total' => 4000000,
            'budget_per_kol' => 400000,
            'kol_slots' => 3,
            'kol_filled' => 1,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(35),
            'deadline_apply' => now()->addDays(3),
            'kol_category' => 'fashion',
        ]);

        $campaign5 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile2->id,
            'title' => 'Soto Mie Bogor - Beauty Review Campaign',
            'status' => CampaignStatus::OPEN,
            'budget_total' => 3500000,
            'budget_per_kol' => 350000,
            'kol_slots' => 3,
            'kol_filled' => 1,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(37),
            'deadline_apply' => now()->addDays(5),
            'kol_category' => 'beauty',
        ]);

        // Hiring Teras Dimsum Mentai -> Anggun (Fashion)
        $hiringAnggun = Hiring::factory()->create([
            'campaign_id' => $campaign4->id,
            'brand_profile_id' => $brandProfile1->id,
            'kol_profile_id' => $kolProfile1->id,
            'initiated_by' => 'brand',
            'status' => HiringStatus::ACCEPTED,
            'proposed_budget' => 400000,
            'agreed_budget' => 400000,
            'message' => 'Hai Anggun! Kami dari Teras Dimsum Mentai ingin mengajak kamu collaborate untuk campaign food fashion kami. Tertarik?',
            'accepted_at' => now()->subDays(3),
            'expires_at' => now()->addDays(7),
        ]);

        Agreement::factory()->create([
            'hiring_id' => $hiringAnggun->id,
            'agreement_number' => 'AGR-SPK-2025-00003',
            'total_amount' => 400000,
            'platform_fee_percent' => 10.00,
            'status' => 'signed',
            'terms' => "1. KOL wajib membuat 1 konten Instagram (reels) dan 1 konten TikTok\n2. Konten harus dipublikasikan dalam 7 hari setelah agreement ditandatangani\n3. KOL wajib mengunjungi langsung outlet Teras Dimsum Mentai\n4. Brand berhak melakukan review sebelum konten dipublikasikan",
            'brand_signed_at' => now()->subDays(2),
            'kol_signed_at' => now()->subDays(2),
            'signed_at' => now()->subDays(2),
            'expires_at' => now()->addDays(10),
        ]);

        // Hiring Soto Mie Bogor -> Cindi Widia (Beauty)
        $hiringCindi = Hiring::factory()->create([
            'campaign_id' => $campaign5->id,
            'brand_profile_id' => $brandProfile2->id,
            'kol_profile_id' => $kolProfile2->id,
            'initiated_by' => 'brand',
            'status' => HiringStatus::ACCEPTED,
            'proposed_budget' => 350000,
            'agreed_budget' => 350000,
            'message' => 'Hai Cindi! Soto Mie Bogor ingin mengajak kamu untuk campaign review menu kami. Tertarik?',
            'accepted_at' => now()->subDays(3),
            'expires_at' => now()->addDays(7),
        ]);

        Agreement::factory()->create([
            'hiring_id' => $hiringCindi->id,
            'agreement_number' => 'AGR-SPK-2025-00004',
            'total_amount' => 350000,
            'platform_fee_percent' => 10.00,
            'status' => 'signed',
            'terms' => "1. KOL wajib membuat 1 konten Instagram (feed) dan 1 konten TikTok\n2. Konten harus dipublikasikan dalam 7 hari setelah agreement ditandatangani\n3. KOL wajib mengunjungi langsung outlet Soto Mie Bogor\n4. Brand berhak melakukan review sebelum konten dipublikasikan",
            'brand_signed_at' => now()->subDays(2),
            'kol_signed_at' => now()->subDays(2),
            'signed_at' => now()->subDays(2),
            'expires_at' => now()->addDays(10),
        ]);

        // Hiring Teras Dimsum Mentai -> Tata
        $hiring1 = Hiring::factory()->create([
            'campaign_id' => $campaign2->id,
            'brand_profile_id' => $brandProfile1->id,
            'kol_profile_id' => $kolProfile3->id,
            'initiated_by' => 'brand',
            'status' => HiringStatus::ACCEPTED,
            'proposed_budget' => 300000,
            'agreed_budget' => 300000,
            'message' => 'Hai Tata! Kami dari Teras Dimsum Mentai tertarik untuk mengajak kamu mereview menu terbaru kami. Tertarik?',
            'accepted_at' => now()->subDays(2),
            'expires_at' => now()->addDays(5),
        ]);

        $hiring2 = Hiring::factory()->create([
            'campaign_id' => $campaign1->id,
            'brand_profile_id' => $brandProfile1->id,
            'kol_profile_id' => $kolProfile3->id,
            'initiated_by' => 'brand',
            'status' => HiringStatus::NEGOTIATING,
            'proposed_budget' => 500000,
            'message' => 'Tata, kami mau ajak kamu collaborate untuk campaign food review Teras Dimsum Mentai! Mohon konfirmasi.',
            'expires_at' => now()->addDays(7),
        ]);

        $hiring3 = Hiring::factory()->create([
            'campaign_id' => $campaign3->id,
            'brand_profile_id' => $brandProfile2->id,
            'kol_profile_id' => $kolProfile3->id,
            'initiated_by' => 'brand',
            'status' => HiringStatus::PENDING,
            'proposed_budget' => 300000,
            'message' => 'Hai Tata! Soto Mie Bogor ingin mengajak kamu kerja sama untuk review menu kami. Tertarik?',
            'expires_at' => now()->addDays(7),
        ]);

        $agreement1 = Agreement::factory()->create([
            'hiring_id' => $hiring1->id,
            'agreement_number' => 'AGR-SPK-2025-00001',
            'total_amount' => 300000,
            'platform_fee_percent' => 10.00,
            'status' => 'signed',
            'terms' => "1. KOL wajib membuat 1 konten Instagram (feed) dan 1 konten TikTok\n2. Konten harus dipublikasikan dalam 7 hari setelah agreement ditandatangani\n3. KOL wajib mengunjungi langsung outlet Teras Dimsum Mentai\n4. Brand berhak melakukan review sebelum konten dipublikasikan",
            'brand_signed_at' => now()->subDays(2),
            'kol_signed_at' => now()->subDays(2),
            'signed_at' => now()->subDays(2),
            'expires_at' => now()->addDays(8),
        ]);

        Agreement::factory()->create([
            'hiring_id' => $hiring2->id,
            'agreement_number' => 'AGR-SPK-2025-00002',
            'total_amount' => 500000,
            'platform_fee_percent' => 10.00,
            'status' => 'draft',
            'expires_at' => now()->addDays(7),
        ]);
    }
}
