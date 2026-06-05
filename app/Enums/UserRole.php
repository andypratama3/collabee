<?php

namespace App\Enums;

enum UserRole: string
{
    case BRAND = 'brand';
    case KOL = 'kol';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';
}
