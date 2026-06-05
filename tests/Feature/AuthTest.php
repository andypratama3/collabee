<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

test('brand registration creates user and brand profile', function () {
    $response = $this->post(route('register.brand'), [
        'name' => 'PT Maju Jaya',
        'email' => 'brand@example.com',
        'phone' => '08123456789',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'brand_name' => 'PT Maju Jaya',
        'industry' => 'fashion',
        'location' => 'Jakarta',
        'website' => 'https://majujaya.com',
    ]);

    $response->assertRedirect(route('verification.notice'));

    $this->assertDatabaseHas('users', [
        'email' => 'brand@example.com',
        'user_type' => 'brand',
    ]);

    $this->assertDatabaseHas('brand_profiles', [
        'brand_name' => 'PT Maju Jaya',
        'industry' => 'fashion',
    ]);
});

test('KOL registration creates user and kol profile', function () {
    $response = $this->post(route('register.kol'), [
        'name' => 'Budi Santoso',
        'email' => 'kol@example.com',
        'phone' => '08123456788',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'display_name' => 'Budi Santoso',
        'category' => 'fashion',
        'location' => 'Bandung',
        'bio' => 'Fashion KOL',
    ]);

    $response->assertRedirect(route('verification.notice'));

    $this->assertDatabaseHas('users', [
        'email' => 'kol@example.com',
        'user_type' => 'kol',
    ]);

    $this->assertDatabaseHas('kol_profiles', [
        'display_name' => 'Budi Santoso',
        'category' => 'fashion',
    ]);
});

test('login with valid credentials', function () {
    $user = User::factory()->brand()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $this->assertAuthenticated();
});

test('login with invalid credentials', function () {
    $user = User::factory()->brand()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('email verification flow', function () {
    $user = User::factory()->brand()->unverified()->create();

    $this->actingAs($user);

    $response = $this->get(route('verification.notice'));
    $response->assertSuccessful();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
    );

    $response = $this->get($verificationUrl);
    $response->assertRedirect();

    $this->assertTrue($user->fresh()->hasVerifiedEmail());
});

test('forgot password sends reset link', function () {
    Notification::fake();

    $user = User::factory()->brand()->create();

    $response = $this->post(route('password.email'), [
        'email' => $user->email,
    ]);

    $response->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password with valid token', function () {
    $user = User::factory()->brand()->create();

    $token = Password::createToken($user);

    $response = $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'NewPassword123!',
        'password_confirmation' => 'NewPassword123!',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('status');
});
