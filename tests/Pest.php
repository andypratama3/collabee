<?php

use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

uses(
    TestCase::class,
    LazilyRefreshDatabase::class,
)->in('Feature', 'Unit')->beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});
