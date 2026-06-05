<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case HELD = 'held';
    case RELEASED = 'released';
    case REFUNDED = 'refunded';
    case EXPIRED = 'expired';
    case FAILED = 'failed';
}
