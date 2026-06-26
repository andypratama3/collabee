<?php

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

beforeEach(function () {
    $this->adminUser = User::factory()->superAdmin()->create();
    $this->adminUser->assignRole('super_admin');
    $this->actingAs($this->adminUser);
});

test('admin dashboard loads', function () {
    $response = $this->get(route('admin.dashboard'));
    $response->assertSuccessful();
});

test('admin users page loads', function () {
    $response = $this->get(route('admin.users'));
    $response->assertSuccessful();
});

test('admin campaigns page loads', function () {
    $response = $this->get(route('admin.campaigns'));
    $response->assertSuccessful();
});

test('admin payments page loads', function () {
    $response = $this->get(route('admin.payments'));
    $response->assertSuccessful();
});

test('admin withdrawals page loads', function () {
    $response = $this->get(route('admin.withdrawals'));
    $response->assertSuccessful();
});

test('admin disputes page loads', function () {
    $response = $this->get(route('admin.disputes'));
    $response->assertSuccessful();
});

test('admin activity log page loads', function () {
    $response = $this->get(route('admin.activity-log'));
    $response->assertSuccessful();
});

test('admin settings page loads', function () {
    $response = $this->get(route('admin.settings'));
    $response->assertSuccessful();
});

test('admin can impersonate brand user', function () {
    $this->withoutMiddleware(ValidateCsrfToken::class);
    $brandUser = User::factory()->brand()->create();
    $brandUser->assignRole('brand');

    $response = $this->post(route('admin.users.impersonate', $brandUser));

    $response->assertSessionHas('success');
    $this->assertEquals($brandUser->id, auth()->id());
});

test('admin can stop impersonation', function () {
    $this->withoutMiddleware(ValidateCsrfToken::class);
    $brandUser = User::factory()->brand()->create();
    $brandUser->assignRole('brand');

    $this->post(route('admin.users.impersonate', $brandUser));
    $this->assertEquals($brandUser->id, auth()->id());

    $response = $this->post(route('admin.users.stop-impersonate'));

    $response->assertSessionHas('success');
    $this->assertEquals($this->adminUser->id, auth()->id());
});

test('non-admin cannot access admin pages', function () {
    $brandUser = User::factory()->brand()->create();
    $brandUser->assignRole('brand');
    $this->actingAs($brandUser);

    $this->get(route('admin.dashboard'))->assertForbidden();
    $this->get(route('admin.users'))->assertForbidden();
    $this->get(route('admin.campaigns'))->assertForbidden();
});

test('admin cannot impersonate another admin', function () {
    $this->withoutMiddleware(ValidateCsrfToken::class);
    $otherAdmin = User::factory()->admin()->create();
    $otherAdmin->assignRole('admin');

    $response = $this->post(route('admin.users.impersonate', $otherAdmin));

    $response->assertSessionHas('error');
});
