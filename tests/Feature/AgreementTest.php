<?php

use App\Enums\HiringStatus;
use App\Models\Agreement;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\User;
use App\Services\Campaign\AgreementService;

beforeEach(function () {
    $this->brandUser = User::factory()->brand()->create();
    $this->brandProfile = BrandProfile::factory()->create(['user_id' => $this->brandUser->id, 'profile_completed_at' => now()]);
    $this->kolUser = User::factory()->kol()->create();
    $this->kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id, 'profile_completed_at' => now()]);
    $this->campaign = Campaign::factory()->create(['brand_profile_id' => $this->brandProfile->id]);
    $this->hiring = Hiring::factory()->create([
        'campaign_id' => $this->campaign->id,
        'brand_profile_id' => $this->brandProfile->id,
        'kol_profile_id' => $this->kolProfile->id,
        'status' => HiringStatus::ACCEPTED,
    ]);
    $this->agreement = Agreement::factory()->create([
        'hiring_id' => $this->hiring->id,
        'status' => 'draft',
        'total_amount' => 1000000,
    ]);
});

test('brand can view agreements', function () {
    $this->actingAs($this->brandUser);
    $response = $this->get(route('brand.agreement.index'));
    $response->assertSuccessful();
});

test('brand can view single agreement', function () {
    $this->actingAs($this->brandUser);
    $response = $this->get(route('brand.agreement.show', $this->agreement));
    $response->assertSuccessful();
});

test('kol can view agreements', function () {
    $this->actingAs($this->kolUser);
    $response = $this->get(route('kol.agreement.index'));
    $response->assertSuccessful();
});

test('kol can view single agreement', function () {
    $this->actingAs($this->kolUser);
    $response = $this->get(route('kol.agreement.show', $this->agreement));
    $response->assertSuccessful();
});

test('brand can sign agreement', function () {
    $service = app(AgreementService::class);
    $result = $service->signAsBrand($this->agreement);

    expect($result->status)->toBe('draft')
        ->and($result->brand_signed_at)->not->toBeNull()
        ->and($result->brand_signed_ip)->not->toBeNull();
});

test('kol can sign agreement', function () {
    $this->agreement->update(['brand_signed_at' => now()]);

    $this->actingAs($this->kolUser);
    $service = app(AgreementService::class);
    $result = $service->signAsKol($this->agreement);

    expect($result->status)->toBe('signed')
        ->and($result->kol_signed_at)->not->toBeNull()
        ->and($result->signed_at)->not->toBeNull();
});

test('agreement requires both parties to sign', function () {
    $service = app(AgreementService::class);
    $signedByBrand = $service->signAsBrand($this->agreement);

    expect($signedByBrand->status)->toBe('draft')
        ->and($signedByBrand->kol_signed_at)->toBeNull()
        ->and($signedByBrand->signed_at)->toBeNull();
});

test('brand cannot view other brand agreement', function () {
    $otherBrandUser = User::factory()->brand()->create();
    BrandProfile::factory()->create(['user_id' => $otherBrandUser->id, 'profile_completed_at' => now()]);
    $this->actingAs($otherBrandUser);

    $response = $this->get(route('brand.agreement.show', $this->agreement));
    $response->assertForbidden();
});

test('kol cannot view other kol agreement', function () {
    $otherKolUser = User::factory()->kol()->create();
    KolProfile::factory()->create(['user_id' => $otherKolUser->id, 'profile_completed_at' => now()]);
    $this->actingAs($otherKolUser);

    $response = $this->get(route('kol.agreement.show', $this->agreement));
    $response->assertForbidden();
});

test('brand can view payments page', function () {
    $this->actingAs($this->brandUser);
    $response = $this->get(route('brand.payment.index'));
    $response->assertSuccessful();
});

test('kol can view withdrawals page', function () {
    $this->actingAs($this->kolUser);
    $response = $this->get(route('kol.withdrawal.index'));
    $response->assertSuccessful();
});
