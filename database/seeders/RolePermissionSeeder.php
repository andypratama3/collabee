<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionsByRole = [
            UserRole::SUPER_ADMIN->value => [
                // User management
                'users.view', 'users.create', 'users.edit', 'users.delete', 'users.impersonate',
                'users.activate', 'users.verify',
                // Campaign management
                'campaigns.view', 'campaigns.create', 'campaigns.edit', 'campaigns.delete',
                'campaigns.feature', 'campaigns.suspend',
                // Hiring management
                'hirings.view', 'hirings.edit', 'hirings.cancel',
                // Payment management
                'payments.view', 'payments.refund', 'payments.export',
                // Withdrawal management
                'withdrawals.view', 'withdrawals.approve', 'withdrawals.reject',
                // Content management
                'contents.view', 'contents.delete',
                // Dispute management
                'disputes.view', 'disputes.edit', 'disputes.resolve',
                // Platform settings
                'settings.view', 'settings.edit',
                // Activity log
                'activity_logs.view',
                // Analytics
                'analytics.view',
            ],
            UserRole::ADMIN->value => [
                'users.view', 'users.edit', 'users.activate', 'users.verify',
                'campaigns.view', 'campaigns.feature', 'campaigns.suspend',
                'hirings.view',
                'payments.view', 'payments.refund', 'payments.export',
                'withdrawals.view', 'withdrawals.approve', 'withdrawals.reject',
                'contents.view',
                'disputes.view', 'disputes.edit', 'disputes.resolve',
                'settings.view', 'settings.edit',
                'activity_logs.view',
                'analytics.view',
            ],
            UserRole::BRAND->value => [
                'campaigns.view', 'campaigns.create', 'campaigns.edit', 'campaigns.delete',
                'hirings.view', 'hirings.create', 'hirings.edit',
                'chat.send', 'chat.view',
                'agreements.view', 'agreements.sign',
                'payments.view', 'payments.create',
                'contents.view', 'contents.review',
                'ratings.create', 'ratings.view',
                'disputes.create', 'disputes.view',
            ],
            UserRole::KOL->value => [
                'campaigns.view',
                'hirings.view', 'hirings.apply',
                'chat.send', 'chat.view',
                'agreements.view', 'agreements.sign',
                'payments.view',
                'contents.create', 'contents.edit', 'contents.view',
                'withdrawals.create', 'withdrawals.view',
                'ratings.create', 'ratings.view',
                'disputes.create', 'disputes.view',
            ],
        ];

        $roles = [];

        foreach ($permissionsByRole as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $roles[$roleName] = $role;

            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
            }

            $role->givePermissionTo($permissions);
        }
    }
}
