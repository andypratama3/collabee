<?php

namespace App\Enums;

enum HiringStatus: string
{
    case PENDING = 'pending';
    case NEGOTIATING = 'negotiating';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
