<?php

namespace App\Enums;

enum EscrowStatus: string
{
    case HELD = 'held';
    case PARTIALLY_RELEASED = 'partially_released';
    case RELEASED = 'released';
    case REFUNDED = 'refunded';
    case DISPUTED = 'disputed';
}
