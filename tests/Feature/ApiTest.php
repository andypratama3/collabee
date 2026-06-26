<?php

use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\KolProfile;
use App\Models\User;

beforeEach(function () {
    $this->brandUser = User::factory()->brand()->create();
    $this->brandUser->assignRole('brand');
    BrandProfile::factory()->create(['user_id' => $this->brandUser->id]);

    $this->kolUser = User::factory()->kol()->create();
    $this->kolUser->assignRole('kol');
    KolProfile::factory()->create(['user_id' => $this->kolUser->id]);

    $this->campaign = Campaign::factory()->create([
        'brand_profile_id' => $this->brandUser->brandProfile->id,
        'status' => 'open',
    ]);
});

test('api login with valid credentials', function () {
    $response = $this->postJson('/api/v1/auth/login', [
        'email' => $this->brandUser->email,
        'password' => 'password',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['data' => ['token', 'user']]);
});

test('api login with invalid credentials returns error', function () {
    $response = $this->postJson('/api/v1/auth/login', [
        'email' => $this->brandUser->email,
        'password' => 'wrong-password',
    ]);

    $response->assertUnauthorized();
});

test('api register brand', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name' => 'Brand Baru',
        'email' => 'brandbaru@test.test',
        'password' => 'password',
        'password_confirmation' => 'password',
        'user_type' => 'brand',
        'phone' => '08123456789',
        'brand_name' => 'Brand Baru',
        'industry' => 'fashion',
    ]);

    $response->assertCreated()
        ->assertJsonStructure(['data' => ['token', 'user']]);
});

test('api register kol', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name' => 'KOL Baru',
        'email' => 'kolbaru@test.test',
        'password' => 'password',
        'password_confirmation' => 'password',
        'user_type' => 'kol',
        'phone' => '08123456780',
        'display_name' => 'KOL Baru',
        'category' => 'technology',
    ]);

    $response->assertCreated()
        ->assertJsonStructure(['data' => ['token', 'user']]);
});

test('api show authenticated user', function () {
    $token = $this->brandUser->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/v1/auth/me');

    $response->assertOk()
        ->assertJsonPath('data.email', $this->brandUser->email);
});

test('api list campaigns', function () {
    $token = $this->kolUser->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/v1/campaigns');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

test('api show campaign detail', function () {
    $token = $this->kolUser->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/v1/campaigns/'.$this->campaign->id);

    $response->assertOk()
        ->assertJsonPath('data.id', $this->campaign->id);
});

test('api list KOLs', function () {
    $response = $this->getJson('/api/v1/kols');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

test('api show KOL detail', function () {
    $kolProfile = $this->kolUser->kolProfile;

    $response = $this->getJson('/api/v1/kols/'.$kolProfile->id);

    $response->assertOk()
        ->assertJsonPath('data.id', $kolProfile->id);
});

test('api apply to campaign', function () {
    $token = $this->kolUser->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->postJson('/api/v1/campaigns/'.$this->campaign->id.'/apply', [
            'proposed_budget' => 1000000,
            'message' => 'Saya tertarik!',
        ]);

    $response->assertCreated();
});

test('api notifications list', function () {
    $token = $this->brandUser->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/v1/notifications');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

test('api chat rooms for brand', function () {
    $token = $this->brandUser->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $token")
        ->getJson('/api/v1/chat/rooms');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

test('unauthenticated api requests return error', function () {
    $response = $this->getJson('/api/v1/auth/me');
    $response->assertUnauthorized();
});

test('api register with validation error', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name' => '',
        'email' => 'invalid',
        'password' => 'short',
    ]);

    $response->assertUnprocessable();
});
