<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'kol_profile_id',
        'amount',
        'admin_fee',
        'net_amount',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'status',
        'admin_note',
        'proof_path',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'admin_fee' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'processed_at' => 'datetime',
        ];
    }

    public function kolProfile(): BelongsTo
    {
        return $this->belongsTo(KolProfile::class);
    }
}
