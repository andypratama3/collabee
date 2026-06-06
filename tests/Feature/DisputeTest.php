<?php

use App\Enums\HiringStatus;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Dispute;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\User;

beforeEach(function () {
    $this->brandUser = User::factory()->brand()->create();
    $this->brandProfile = BrandProfile::factory()->create(['user_id' => $this->brandUser->id]);
    $this->kolUser = User::factory()->kol()->create();
    $this->kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);
    $this->campaign = Campaign::factory()->create(['brand_profile_id' => $this->brandProfile->id]);
    $this->hiring = Hiring::factory()->create([
        'campaign_id' => $this->campaign->id,
        'brand_profile_id' => $this->brandProfile->id,
        'kol_profile_id' => $this->kolProfile->id,
        'status' => HiringStatus::ACCEPTED,
    ]);
});

test('brand can create dispute', function () {
    $this->actingAs($this->brandUser);

    $dispute = Dispute::create([
        'hiring_id' => $this->hiring->id,
        'raised_by' => $this->brandUser->id,
        'against_id' => $this->kolUser->id,
        'subject' => 'Konten tidak sesuai dengan brief',
        'description' => 'Konten tidak sesuai dengan brief',
        'status' => 'open',
    ]);

    expect($dispute)->toBeInstanceOf(Dispute::class)
        ->and($dispute->status)->toBe('open')
        ->and($dispute->subject)->toBe('Konten tidak sesuai dengan brief');
});

test('kol can create dispute', function () {
    $this->actingAs($this->kolUser);

    $dispute = Dispute::create([
        'hiring_id' => $this->hiring->id,
        'raised_by' => $this->kolUser->id,
        'against_id' => $this->brandUser->id,
        'subject' => 'Pembayaran belum diterima setelah konten disetujui',
        'description' => 'Pembayaran belum diterima setelah konten disetujui',
        'status' => 'open',
    ]);

    expect($dispute->status)->toBe('open');
});

test('dispute can be resolved by admin', function () {
    $dispute = Dispute::create([
        'hiring_id' => $this->hiring->id,
        'raised_by' => $this->brandUser->id,
        'against_id' => $this->kolUser->id,
        'subject' => 'Test dispute',
        'description' => 'Test dispute',
        'status' => 'open',
    ]);

    $dispute->update([
        'status' => 'resolved',
        'resolved_at' => now(),
    ]);

    expect($dispute->status)->toBe('resolved');
});

test('dispute belongs to hiring', function () {
    $dispute = Dispute::create([
        'hiring_id' => $this->hiring->id,
        'raised_by' => $this->brandUser->id,
        'against_id' => $this->kolUser->id,
        'subject' => 'Test dispute relationship',
        'description' => 'Test dispute relationship',
        'status' => 'open',
    ]);

    expect($dispute->hiring->id)->toBe($this->hiring->id);
});

test('admin can view disputes', function () {
    $adminUser = User::factory()->superAdmin()->create();
    $adminUser->assignRole('super_admin');
    $this->actingAs($adminUser);

    $response = $this->get(route('admin.disputes'));
    $response->assertSuccessful();
});
