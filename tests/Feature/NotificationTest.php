<?php

use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\User;
use App\Services\Notification\NotificationService;

beforeEach(function () {
    Notification::fake();

    $this->brandUser = User::factory()->brand()->create();
    $this->brandProfile = BrandProfile::factory()->create(['user_id' => $this->brandUser->id]);
    $this->kolUser = User::factory()->kol()->create();
    $this->kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);
    $this->campaign = Campaign::factory()->create(['brand_profile_id' => $this->brandProfile->id]);
    $this->hiring = Hiring::factory()->create([
        'campaign_id' => $this->campaign->id,
        'brand_profile_id' => $this->brandProfile->id,
        'kol_profile_id' => $this->kolProfile->id,
    ]);
});

test('notification service sends database notification', function () {
    $service = app(NotificationService::class);
    $service->send($this->kolUser, 'hiring', 'Anda mendapat tawaran hiring baru', 'Silakan cek detail hiring anda.', ['hiring' => $this->hiring]);

    $this->assertDatabaseHas('notifications', [
        'user_id' => $this->kolUser->id,
        'type' => 'hiring',
        'title' => 'Anda mendapat tawaran hiring baru',
        'body' => 'Silakan cek detail hiring anda.',
    ]);
});

test('notification service creates notification for brand', function () {
    $service = app(NotificationService::class);
    $service->send($this->brandUser, 'hiring', 'KOL telah menerima tawaran', 'KOL telah menerima tawaran hiring.', ['hiring' => $this->hiring]);

    $this->assertDatabaseHas('notifications', [
        'user_id' => $this->brandUser->id,
        'type' => 'hiring',
        'title' => 'KOL telah menerima tawaran',
    ]);
});

test('notification stores data payload correctly', function () {
    $service = app(NotificationService::class);
    $notification = $service->send($this->kolUser, 'hiring', 'Test data', 'Test body', ['hiring' => $this->hiring, 'key' => 'value']);

    expect($notification->type)->toBe('hiring');
    expect($notification->is_read)->toBeFalse();
    expect($notification->data)->toHaveKey('key', 'value');
});

test('brand can view notifications page', function () {
    $this->actingAs($this->brandUser);
    $response = $this->get(route('notifications.index'));
    $response->assertSuccessful();
});

test('kol can view notifications page', function () {
    $this->actingAs($this->kolUser);
    $response = $this->get(route('notifications.index'));
    $response->assertSuccessful();
});

test('notification mailable only sends for hiring type on Hiring model', function () {
    $service = app(NotificationService::class);

    $reflection = new ReflectionMethod($service, 'getMailableForType');
    $reflection->setAccessible(true);
    $mailable = $reflection->invoke($service, 'hiring', ['hiring' => $this->hiring]);

    expect($mailable)->not->toBeNull();
});

test('notification mailable returns null for non-hiring on non-Hiring model', function () {
    $service = app(NotificationService::class);

    $reflection = new ReflectionMethod($service, 'getMailableForType');
    $reflection->setAccessible(true);
    $mailable = $reflection->invoke($service, 'campaign', ['hiring' => $this->campaign]);

    expect($mailable)->toBeNull();
});

test('notification mailable returns null for hiring type on non-Hiring model', function () {
    $service = app(NotificationService::class);

    $reflection = new ReflectionMethod($service, 'getMailableForType');
    $reflection->setAccessible(true);
    $mailable = $reflection->invoke($service, 'hiring', ['hiring' => $this->campaign]);

    expect($mailable)->toBeNull();
});
