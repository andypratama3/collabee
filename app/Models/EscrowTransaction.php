<?php

namespace App\Models;

use App\Enums\EscrowStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EscrowTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'amount_held',
        'platform_fee',
        'kol_amount',
        'status',
        'release_trigger',
        'held_at',
        'released_at',
    ];

    protected function casts(): array
    {
        return [
            'amount_held' => 'decimal:2',
            'platform_fee' => 'decimal:2',
            'kol_amount' => 'decimal:2',
            'held_at' => 'datetime',
            'released_at' => 'datetime',
            'status' => EscrowStatus::class,
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
