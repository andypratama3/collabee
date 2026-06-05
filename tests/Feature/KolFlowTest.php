<?php

use App\Enums\ContentStatus;
use App\Enums\HiringStatus;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Content;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\KolWithdrawal;
use App\Models\User;
use App\Services\Content\ContentService;
use App\Services\Kol\KolProfileService;
use App\Services\Campaign\HiringService;

beforeEach(function () {
    $this->kolUser = User::factory()->kol()->create();
    $this->actingAs($this->kolUser);
});

test('KOL profile creation', function () {
    $service = app(KolProfileService::class);

    $profile = $service->create([
        'display_name' => 'Budi Influencer',
        'bio' => 'Content creator fashion',
        'category' => 'fashion',
        'location' => 'Jakarta',
        'gender' => 'male',
        'is_open_for_work' => true,
        'min_budget' => 500000,
    ], $this->kolUser);

    expect($profile)->toBeInstanceOf(KolProfile::class)
        ->and($profile->display_name)->toBe('Budi Influencer')
        ->and($profile->user_id)->toBe($this->kolUser->id)
        ->and($profile->profile_completed_at)->not->toBeNull();
});

test('KOL profile update', function () {
    $profile = KolProfile::factory()->create([
        'user_id' => $this->kolUser->id,
        'display_name' => 'Old Name',
    ]);

    $service = app(KolProfileService::class);
    $updated = $service->update([
        'display_name' => 'New Name',
        'bio' => 'Updated bio',
    ], $profile);

    expect($updated->display_name)->toBe('New Name')
        ->and($updated->bio)->toBe('Updated bio');
});

test('KOL apply to campaign', function () {
    $brandUser = User::factory()->brand()->create();
    $brandProfile = BrandProfile::factory()->create(['user_id' => $brandUser->id]);

    $campaign = Campaign::factory()->create([
        'brand_profile_id' => $brandProfile->id,
        'status' => 'open',
        'kol_slots' => 5,
    ]);

    $kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);

    $service = app(HiringService::class);
    $application = $service->apply($campaign, $kolProfile, [
        'proposed_budget' => 1000000,
        'message' => 'Saya tertarik!',
    ]);

    expect($application)->toBeInstanceOf(\App\Models\HiringApplication::class)
        ->and($application->campaign_id)->toBe($campaign->id)
        ->and($application->kol_profile_id)->toBe($kolProfile->id);
});

test('KOL accept hiring', function () {
    $brandUser = User::factory()->brand()->create();
    $brandProfile = BrandProfile::factory()->create(['user_id' => $brandUser->id]);
    $kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);

    $campaign = Campaign::factory()->create([
        'brand_profile_id' => $brandProfile->id,
        'status' => 'open',
        'kol_slots' => 5,
    ]);

    $hiring = Hiring::factory()->create([
        'campaign_id' => $campaign->id,
        'brand_profile_id' => $brandProfile->id,
        'kol_profile_id' => $kolProfile->id,
        'status' => HiringStatus::PENDING,
    ]);

    $service = app(HiringService::class);
    $accepted = $service->accept($hiring);

    expect($accepted->status)->toBe(HiringStatus::ACCEPTED)
        ->and($accepted->accepted_at)->not->toBeNull();
});

test('KOL reject hiring', function () {
    $brandUser = User::factory()->brand()->create();
    $brandProfile = BrandProfile::factory()->create(['user_id' => $brandUser->id]);
    $kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);

    $campaign = Campaign::factory()->create([
        'brand_profile_id' => $brandProfile->id,
    ]);

    $hiring = Hiring::factory()->create([
        'campaign_id' => $campaign->id,
        'brand_profile_id' => $brandProfile->id,
        'kol_profile_id' => $kolProfile->id,
        'status' => HiringStatus::PENDING,
    ]);

    $service = app(HiringService::class);
    $rejected = $service->reject($hiring, 'Tidak cocok');

    expect($rejected->status)->toBe(HiringStatus::REJECTED)
        ->and($rejected->rejected_reason)->toBe('Tidak cocok');
});

test('KOL content upload', function () {
    $brandUser = User::factory()->brand()->create();
    $brandProfile = BrandProfile::factory()->create(['user_id' => $brandUser->id]);
    $kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);

    $campaign = Campaign::factory()->create(['brand_profile_id' => $brandProfile->id]);
    $hiring = Hiring::factory()->create([
        'campaign_id' => $campaign->id,
        'brand_profile_id' => $brandProfile->id,
        'kol_profile_id' => $kolProfile->id,
        'status' => HiringStatus::ACCEPTED,
    ]);
    $agreement = \App\Models\Agreement::factory()->create([
        'hiring_id' => $hiring->id,
    ]);

    $service = app(ContentService::class);
    $content = $service->upload($kolProfile, $agreement, [
        'title' => 'Content Test',
        'caption' => 'Caption test',
    ], collect([]));

    expect($content)->toBeInstanceOf(Content::class)
        ->and($content->title)->toBe('Content Test')
        ->and($content->status)->toBe(ContentStatus::DRAFT);
});

test('KOL earnings and withdrawal', function () {
    $kolProfile = KolProfile::factory()->create([
        'user_id' => $this->kolUser->id,
        'wallet_balance' => 500000,
    ]);

    $bankAccount = \App\Models\KolBankAccount::factory()->create([
        'kol_profile_id' => $kolProfile->id,
    ]);

    $service = app(\App\Services\Payment\WithdrawalService::class);
    $withdrawal = $service->requestWithdrawal($kolProfile, 200000, $bankAccount->id);

    expect($withdrawal)->toBeInstanceOf(KolWithdrawal::class)
        ->and($withdrawal->status)->toBe('pending')
        ->and($withdrawal->amount)->toEqual(200000.00);
});
