<?php

namespace App\Services\Auth;

use App\Enums\UserRole;
use App\Models\BrandProfile;
use App\Models\KolProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    public function registerBrand(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'user_type' => UserRole::BRAND,
            ]);

            $user->assignRole(UserRole::BRAND->value);

            BrandProfile::create([
                'user_id' => $user->id,
                'brand_name' => $data['brand_name'],
                'industry' => $data['industry'],
                'location' => $data['location'] ?? null,
                'website' => $data['website'] ?? null,
            ]);

            $user->sendEmailVerificationNotification();

            return $user;
        });
    }

    public function registerKol(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'user_type' => UserRole::KOL,
            ]);

            $user->assignRole(UserRole::KOL->value);

            KolProfile::create([
                'user_id' => $user->id,
                'display_name' => $data['display_name'],
                'category' => $data['category'],
                'location' => $data['location'] ?? null,
                'bio' => $data['bio'] ?? null,
            ]);

            $user->sendEmailVerificationNotification();

            return $user;
        });
    }
}
