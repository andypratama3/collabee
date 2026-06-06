<?php

namespace App\Enums;

enum UserRole: string
{
    case BRAND = 'brand';
    case KOL = 'kol';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';

    public function label(): string
    {
        return match ($this) {
            self::BRAND => 'Brand',
            self::KOL => 'KOL',
            self::ADMIN => 'Admin',
            self::SUPER_ADMIN => 'Super Admin',
        };
    }
}
