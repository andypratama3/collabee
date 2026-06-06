<?php

use App\Models\BrandProfile;
use App\Models\User;
use App\Services\Brand\BrandProfileService;

beforeEach(function () {
    $this->brandUser = User::factory()->brand()->create();
    $this->actingAs($this->brandUser);
});

test('brand can create profile', function () {
    $service = app(BrandProfileService::class);
    $profile = $service->create([
        'brand_name' => 'Brand Test',
        'description' => 'Deskripsi brand',
        'industry' => 'fashion',
        'location' => 'Jakarta',
        'website' => 'https://brandtest.test',
    ], $this->brandUser);

    expect($profile)->toBeInstanceOf(BrandProfile::class)
        ->and($profile->brand_name)->toBe('Brand Test')
        ->and($profile->user_id)->toBe($this->brandUser->id)
        ->and($profile->profile_completed_at)->not->toBeNull();
});

test('brand can update profile', function () {
    $profile = BrandProfile::factory()->create([
        'user_id' => $this->brandUser->id,
        'brand_name' => 'Old Name',
    ]);

    $service = app(BrandProfileService::class);
    $updated = $service->update([
        'brand_name' => 'New Name',
        'description' => 'Updated description',
    ], $profile);

    expect($updated->brand_name)->toBe('New Name')
        ->and($updated->description)->toBe('Updated description');
});

test('brand profile create page loads', function () {
    $response = $this->get(route('brand.profile.create'));
    $response->assertSuccessful();
});

test('brand profile edit page loads', function () {
    $profile = BrandProfile::factory()->create([
        'user_id' => $this->brandUser->id,
        'profile_completed_at' => now(),
    ]);

    $response = $this->get(route('brand.profile.edit', $profile));
    $response->assertSuccessful();
});

test('brand dashboard loads', function () {
    BrandProfile::factory()->create([
        'user_id' => $this->brandUser->id,
        'profile_completed_at' => now(),
    ]);

    $response = $this->get(route('brand.dashboard'));
    $response->assertSuccessful();
});

test('brand can view contents page', function () {
    BrandProfile::factory()->create([
        'user_id' => $this->brandUser->id,
        'profile_completed_at' => now(),
    ]);

    $response = $this->get(route('brand.content.index'));
    $response->assertSuccessful();
});

test('guest cannot access brand pages', function () {
    $this->post('/logout');

    $this->get(route('brand.dashboard'))->assertRedirect(route('login'));
    $this->get(route('brand.campaign.index'))->assertRedirect(route('login'));
});
