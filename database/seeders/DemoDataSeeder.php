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
            'total_campaigns' => 3,
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
            'total_campaigns' => 2,
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

        // Campaign 1: Teras Dimsum Mentai - Food Review Campaign
        $campaign1 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile1->id,
            'title' => 'Food Review Campaign – Teras Dimsum Mentai',
            'description' => 'Teras Dimsum Mentai mengajak nano influencer untuk mencoba dan mengulas menu terbaru melalui konten yang menarik, autentik, dan mampu meningkatkan awareness brand di kalangan anak muda dan pecinta kuliner.',
            'brief' => "Teras Dimsum Mentai mengajak nano influencer untuk mencoba dan mengulas menu terbaru melalui konten yang menarik, autentik, dan mampu meningkatkan awareness brand di kalangan anak muda dan pecinta kuliner.\n\nKriteria:\n- Nano Influencer (1.000–10.000 followers)\n- Domisili Pamulang dan sekitarnya\n- Niche kuliner, lifestyle, atau daily vlog\n- Tidak private account\n- Mampu membuat konten review yang natural dan engaging\n\nSOW:\n- 1x Instagram Reels / TikTok Video\n- 1x Instagram Story\n- Menampilkan menu yang dicoba\n- Menandai akun media sosial Teras Dimsum Mentai\n- Menyebutkan nama brand dan lokasi outlet\n\nTimeline:\n- Pendaftaran: 15 Juli 2026\n- Pengumuman: 17 Juli 2026\n- Periode Campaign: 18–25 Juli 2026\n- Upload konten maksimal H+3 setelah kunjungan",
            'objectives' => ['Meningkatkan awareness brand Teras Dimsum Mentai', 'Menjangkau audiens baru di kalangan anak muda dan pecinta kuliner', 'Mendorong kunjungan ke outlet'],
            'platforms' => ['instagram', 'tiktok'],
            'content_types' => ['reels', 'video', 'story'],
            'target_gender' => 'all',
            'location' => 'Pamulang',
            'min_followers' => 1000,
            'max_followers' => 10000,
            'min_engagement' => 2.0,
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

        // Campaign 2: Teras Dimsum Mentai - Review Menu Terbaru
        $campaign2 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile1->id,
            'title' => 'Review Menu Terbaru Teras Dimsum Mentai',
            'description' => 'Kami ingin memperkenalkan menu terbaru kami kepada pecinta kuliner melalui review autentik dari nano influencer.',
            'brief' => "Coba menu terbaru Teras Dimsum Mentai dan bagikan pengalaman kamu!\n\nKriteria:\n- Nano Influencer (1.000–10.000 followers)\n- Domisili Pamulang dan sekitarnya\n- Aktif di Instagram atau TikTok\n- Niche kuliner atau lifestyle\n\nSOW:\n- 1x Instagram Reels / TikTok Video\n- 1x Instagram Story\n- Menampilkan menu yang dicoba\n- Menandai akun media sosial Teras Dimsum Mentai\n\nBenefit:\n- Free menu dari Teras Dimsum Mentai\n- Fee campaign sesuai kategori influencer\n- Kesempatan mengikuti campaign berikutnya\n\nTimeline:\n- Pendaftaran: 20 Juli 2026\n- Pengumuman: 22 Juli 2026\n- Periode Campaign: 23–30 Juli 2026",
            'platforms' => ['instagram', 'tiktok'],
            'content_types' => ['reels', 'video', 'story'],
            'target_gender' => 'all',
            'location' => 'Pamulang',
            'min_followers' => 1000,
            'max_followers' => 10000,
            'min_engagement' => 2.0,
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

        // Campaign 3: Soto Mie Bogor - Food Review Campaign
        $campaign3 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile2->id,
            'title' => 'Food Review Campaign – Soto Mie Bogor',
            'description' => 'Soto Mie Bogor mengajak nano influencer kuliner untuk mencoba dan membagikan pengalaman menikmati menu Soto Mie Bogor melalui konten yang menarik dan autentik. Campaign ini bertujuan meningkatkan awareness brand serta menarik lebih banyak pelanggan lokal.',
            'brief' => "Soto Mie Bogor mengajak nano influencer kuliner untuk mencoba dan membagikan pengalaman menikmati menu Soto Mie Bogor melalui konten yang menarik dan autentik.\n\nKriteria:\n- Nano Influencer (1.000–10.000 followers)\n- Female / Male\n- Domisili Ciater dan sekitarnya\n- Aktif di Instagram atau TikTok\n- Niche kuliner, lifestyle, atau daily vlog\n- Tidak private account\n- Mampu membuat konten review yang natural\n\nSOW:\n- 1x Instagram Reels / TikTok Video\n- 1x Instagram Story\n- Menandai akun brand @sotomiebogor\n- Menyebutkan nama dan lokasi Soto Mie Bogor\n- Menyebutkan cita rasa khas, porsi mengenyangkan, dan harga terjangkau\n\nKey Message:\n- Soto Mie Bogor memiliki cita rasa khas yang lezat\n- Porsi mengenyangkan dengan harga terjangkau\n- Cocok untuk makan bersama teman dan keluarga\n- Kuliner khas Bogor yang wajib dicoba\n\nTimeline:\n- Pendaftaran: 15 Juli 2026\n- Pengumuman: 17 Juli 2026\n- Periode Campaign: 18–25 Juli 2026\n- Upload konten maksimal H+3 setelah kunjungan",
            'objectives' => ['Meningkatkan awareness brand Soto Mie Bogor', 'Menarik lebih banyak pelanggan lokal', 'Memperkenalkan cita rasa khas Soto Mie Bogor'],
            'platforms' => ['instagram', 'tiktok'],
            'content_types' => ['reels', 'video', 'story'],
            'target_gender' => 'all',
            'location' => 'Ciater',
            'min_followers' => 1000,
            'max_followers' => 10000,
            'min_engagement' => 2.0,
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

        // Campaign 4: Soto Mie Bogor - Kuliner Khas Bogor
        $campaign4 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile2->id,
            'title' => 'Kuliner Khas Bogor – Soto Mie Bogor Review',
            'description' => 'Ajak更多 pelanggan untuk mencoba Soto Mie Bogor melalui konten review nan menarik dari para nano influencer.',
            'brief' => "Yuk cobain Soto Mie Bogor dan bagikan pengalaman seru kamu!\n\nKriteria:\n- Nano Influencer (1.000–10.000 followers)\n- Domisili Ciater dan sekitarnya\n- Aktif di Instagram atau TikTok\n- Niche kuliner atau daily vlog\n\nSOW:\n- 1x Instagram Reels / TikTok Video\n- 1x Instagram Story\n- Menandai akun brand @sotomiebogor\n- Menyebutkan nama dan lokasi Soto Mie Bogor\n\nKey Message:\n- Soto Mie Bogor: Kuliner khas Bogor yang wajib dicoba\n- Cocok untuk makan bersama teman dan keluarga\n\nBenefit:\n- Free menu dari Soto Mie Bogor\n- Fee campaign sesuai kategori\n\nTimeline:\n- Pendaftaran: 20 Juli 2026\n- Pengumuman: 22 Juli 2026\n- Periode Campaign: 23–30 Juli 2026",
            'platforms' => ['instagram', 'tiktok'],
            'content_types' => ['reels', 'video', 'story'],
            'target_gender' => 'all',
            'location' => 'Ciater',
            'min_followers' => 1000,
            'max_followers' => 10000,
            'min_engagement' => 2.0,
            'status' => CampaignStatus::OPEN,
            'budget_total' => 3500000,
            'budget_per_kol' => 350000,
            'kol_slots' => 3,
            'kol_filled' => 1,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(37),
            'deadline_apply' => now()->addDays(5),
            'kol_category' => 'food',
        ]);

        // Campaign 5: Teras Dimsum Mentai - Lifestyle Food Campaign
        $campaign5 = Campaign::factory()->create([
            'brand_profile_id' => $brandProfile1->id,
            'title' => 'Teras Dimsum Mentai – Lifestyle & Kuliner Campaign',
            'description' => 'Campaign kolaborasi Teras Dimsum Mentai dengan influencer lifestyle untuk memperluas jangkauan brand.',
            'brief' => "Teras Dimsum Mentai mengajak nano influencer lifestyle & kuliner untuk nongkrong seru sambil menikmati dimsum mentai!\n\nKriteria:\n- Nano Influencer (1.000–10.000 followers)\n- Female / Male\n- Domisili Pamulang dan sekitarnya\n- Niche lifestyle, kuliner, atau daily vlog\n\nSOW:\n- 1x Instagram Reels / TikTok Video\n- 1x Instagram Story\n- Menampilkan suasana outlet dan menu yang dicoba\n- Menandai akun media sosial Teras Dimsum Mentai\n\nKey Message:\n- Dimsum mentai yang lezat dan creamy\n- Tempat nyaman untuk nongkrong\n- Harga terjangkau dengan kualitas premium\n\nBenefit:\n- Free menu + fee campaign\n- Kesempatan collaborate kembali\n\nTimeline:\n- Pendaftaran: 25 Juli 2026\n- Pengumuman: 27 Juli 2026\n- Periode Campaign: 28 Juli – 5 Agustus 2026",
            'platforms' => ['instagram', 'tiktok'],
            'content_types' => ['reels', 'video', 'story'],
            'target_gender' => 'all',
            'location' => 'Pamulang',
            'min_followers' => 1000,
            'max_followers' => 10000,
            'min_engagement' => 2.0,
            'status' => CampaignStatus::OPEN,
            'budget_total' => 4000000,
            'budget_per_kol' => 400000,
            'kol_slots' => 3,
            'kol_filled' => 1,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(35),
            'deadline_apply' => now()->addDays(3),
            'kol_category' => 'food',
        ]);

        // Hiring Teras Dimsum Mentai -> Anggun
        $hiringAnggun = Hiring::factory()->create([
            'campaign_id' => $campaign5->id,
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
            'terms' => "1. KOL wajib membuat 1 konten Instagram Reels / TikTok Video\n2. KOL wajib membuat 1 Instagram Story\n3. Menampilkan menu yang dicoba\n4. Menandai akun media sosial Teras Dimsum Mentai\n5. Menyebutkan nama brand dan lokasi outlet\n6. Konten harus dipublikasikan dalam 7 hari setelah agreement ditandatangani\n7. KOL wajib mengunjungi langsung outlet Teras Dimsum Mentai\n8. Brand berhak melakukan review sebelum konten dipublikasikan",
            'brand_signed_at' => now()->subDays(2),
            'kol_signed_at' => now()->subDays(2),
            'signed_at' => now()->subDays(2),
            'expires_at' => now()->addDays(10),
        ]);

        // Hiring Soto Mie Bogor -> Cindi Widia
        $hiringCindi = Hiring::factory()->create([
            'campaign_id' => $campaign4->id,
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
            'terms' => "1. KOL wajib membuat 1 konten Instagram Reels / TikTok Video\n2. KOL wajib membuat 1 Instagram Story\n3. Menandai akun brand @sotomiebogor\n4. Menyebutkan nama dan lokasi Soto Mie Bogor\n5. Menyebutkan cita rasa khas, porsi mengenyangkan, dan harga terjangkau\n6. Konten harus dipublikasikan dalam 7 hari setelah agreement ditandatangani\n7. KOL wajib mengunjungi langsung outlet Soto Mie Bogor\n8. Brand berhak melakukan review sebelum konten dipublikasikan",
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
            'status' => HiringStatus::ACCEPTED,
            'proposed_budget' => 500000,
            'agreed_budget' => 500000,
            'message' => 'Tata, kami mau ajak kamu collaborate untuk campaign food review Teras Dimsum Mentai! Mohon konfirmasi.',
            'accepted_at' => now()->subDays(1),
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
            'terms' => "1. KOL wajib membuat 1 konten Instagram Reels / TikTok Video\n2. KOL wajib membuat 1 Instagram Story\n3. Menampilkan menu yang dicoba\n4. Menandai akun media sosial Teras Dimsum Mentai\n5. Menyebutkan nama brand dan lokasi outlet\n6. Konten harus dipublikasikan dalam 7 hari setelah agreement ditandatangani\n7. KOL wajib mengunjungi langsung outlet Teras Dimsum Mentai\n8. Brand berhak melakukan review sebelum konten dipublikasikan",
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
