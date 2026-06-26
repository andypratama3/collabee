<?php

use App\Enums\CampaignStatus;
use App\Enums\HiringStatus;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\User;
use App\Services\Campaign\CampaignService;
use App\Services\Campaign\HiringService;

beforeEach(function () {
    $this->brandUser = User::factory()->brand()->create();
    $this->brandProfile = BrandProfile::factory()->create(['user_id' => $this->brandUser->id]);
    $this->actingAs($this->brandUser);
});

test('create campaign as draft', function () {
    $service = app(CampaignService::class);

    $campaign = $service->create($this->brandProfile, [
        'title' => 'Campaign Test',
        'description' => 'Description test',
        'brief' => 'Brief test',
        'platforms' => ['instagram', 'tiktok'],
        'content_types' => ['photo', 'video'],
        'budget_total' => 10000000,
        'budget_per_kol' => 1000000,
        'kol_slots' => 5,
        'start_date' => now()->addDays(7),
        'end_date' => now()->addDays(30),
        'deadline_apply' => now()->addDays(5),
        'status' => CampaignStatus::DRAFT,
    ]);

    expect($campaign)->toBeInstanceOf(Campaign::class)
        ->and($campaign->status)->toBe(CampaignStatus::DRAFT)
        ->and($campaign->title)->toBe('Campaign Test');
});

test('create and publish campaign', function () {
    $service = app(CampaignService::class);

    $campaign = $service->create($this->brandProfile, [
        'title' => 'Campaign Test',
        'description' => 'Description test',
        'brief' => 'Brief test',
        'platforms' => ['instagram'],
        'content_types' => ['photo'],
        'budget_total' => 10000000,
        'budget_per_kol' => 1000000,
        'kol_slots' => 3,
        'start_date' => now()->addDays(7),
        'end_date' => now()->addDays(30),
        'deadline_apply' => now()->addDays(5),
        'status' => CampaignStatus::DRAFT,
    ]);

    $published = $service->publish($campaign);

    expect($published->status)->toBe(CampaignStatus::OPEN);
});

test('edit campaign', function () {
    $service = app(CampaignService::class);

    $campaign = Campaign::factory()->create([
        'brand_profile_id' => $this->brandProfile->id,
        'status' => CampaignStatus::DRAFT,
    ]);

    $updated = $service->update($campaign, [
        'title' => 'Updated Title',
        'description' => 'Updated description',
    ]);

    expect($updated->title)->toBe('Updated Title')
        ->and($updated->description)->toBe('Updated description');
});

test('browse KOL returns available KOLs', function () {
    $kol = User::factory()->kol()->create();
    KolProfile::factory()->create([
        'user_id' => $kol->id,
        'is_open_for_work' => true,
    ]);

    $this->brandProfile->update(['profile_completed_at' => now()]);

    $response = $this->get(route('brand.browse-kol'));

    $response->assertSuccessful();
});

test('hire KOL creates hiring record', function () {
    $campaign = Campaign::factory()->create([
        'brand_profile_id' => $this->brandProfile->id,
        'status' => CampaignStatus::OPEN,
        'kol_slots' => 5,
        'budget_per_kol' => 1000000,
    ]);

    $kolUser = User::factory()->kol()->create();
    $kolProfile = KolProfile::factory()->create(['user_id' => $kolUser->id]);

    $service = app(HiringService::class);
    $hiring = $service->brandHire($campaign, $this->brandProfile, $kolProfile, [
        'message' => 'Tertarik untuk kolaborasi',
        'proposed_budget' => 1000000,
    ]);

    expect($hiring)->toBeInstanceOf(Hiring::class)
        ->and($hiring->campaign_id)->toBe($campaign->id)
        ->and($hiring->kol_profile_id)->toBe($kolProfile->id)
        ->and($hiring->status)->toBe(HiringStatus::PENDING);
});

test('cancel hiring', function () {
    $campaign = Campaign::factory()->create([
        'brand_profile_id' => $this->brandProfile->id,
        'status' => CampaignStatus::OPEN,
    ]);

    $kolUser = User::factory()->kol()->create();
    $kolProfile = KolProfile::factory()->create(['user_id' => $kolUser->id]);

    $hiring = Hiring::factory()->create([
        'campaign_id' => $campaign->id,
        'brand_profile_id' => $this->brandProfile->id,
        'kol_profile_id' => $kolProfile->id,
        'status' => HiringStatus::PENDING,
    ]);

    $service = app(HiringService::class);
    $cancelled = $service->cancel($hiring, 'Dibatalkan oleh brand');

    expect($cancelled->status)->toBe(HiringStatus::CANCELLED)
        ->and($cancelled->note)->toBe('Dibatalkan oleh brand');
});
