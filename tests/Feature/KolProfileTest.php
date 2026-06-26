<?php

use App\Models\KolBankAccount;
use App\Models\KolProfile;
use App\Models\KolSocialAccount;
use App\Models\User;

beforeEach(function () {
    $this->kolUser = User::factory()->kol()->create();
    $this->actingAs($this->kolUser);
});

test('kol dashboard loads', function () {
    KolProfile::factory()->create([
        'user_id' => $this->kolUser->id,
        'profile_completed_at' => now(),
    ]);

    $response = $this->get(route('kol.dashboard'));
    $response->assertSuccessful();
});

test('kol can add social account', function () {
    $kolProfile = KolProfile::factory()->create([
        'user_id' => $this->kolUser->id,
    ]);

    $account = KolSocialAccount::create([
        'kol_profile_id' => $kolProfile->id,
        'platform' => 'instagram',
        'username' => 'test_kol',
        'profile_url' => 'https://instagram.com/test_kol',
        'followers_count' => 10000,
        'engagement_rate' => 3.5,
    ]);

    expect($account)->toBeInstanceOf(KolSocialAccount::class)
        ->and($account->kol_profile_id)->toBe($kolProfile->id);
});

test('kol can add bank account', function () {
    $kolProfile = KolProfile::factory()->create([
        'user_id' => $this->kolUser->id,
    ]);

    $bankAccount = KolBankAccount::create([
        'kol_profile_id' => $kolProfile->id,
        'bank_name' => 'Bank BCA',
        'account_number' => '9876543210',
        'account_name' => $this->kolUser->name,
    ]);

    expect($bankAccount)->toBeInstanceOf(KolBankAccount::class)
        ->and($bankAccount->bank_name)->toBe('Bank BCA');
});

test('kol has social accounts relationship', function () {
    $kolProfile = KolProfile::factory()->create([
        'user_id' => $this->kolUser->id,
    ]);

    KolSocialAccount::create([
        'kol_profile_id' => $kolProfile->id,
        'platform' => 'instagram',
        'username' => 'test_kol',
        'profile_url' => 'https://instagram.com/test_kol',
        'followers_count' => 10000,
    ]);

    expect($kolProfile->socialAccounts)->toHaveCount(1);
});

test('kol contents page loads', function () {
    $kolProfile = KolProfile::factory()->create([
        'user_id' => $this->kolUser->id,
        'profile_completed_at' => now(),
    ]);

    $response = $this->get(route('kol.content.index'));
    $response->assertSuccessful();
});

test('guest cannot access kol pages', function () {
    auth()->logout();

    $this->get(route('kol.dashboard'))->assertRedirect(route('login'));
    $this->get(route('kol.hiring.index'))->assertRedirect(route('login'));
});
