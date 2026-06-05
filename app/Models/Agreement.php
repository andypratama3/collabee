<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'hiring_id',
        'agreement_number',
        'total_amount',
        'platform_fee_percent',
        'terms',
        'status',
        'brand_signed_at',
        'brand_signed_ip',
        'kol_signed_at',
        'kol_signed_ip',
        'signed_at',
        'expires_at',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'platform_fee_percent' => 'decimal:2',
            'brand_signed_at' => 'datetime',
            'kol_signed_at' => 'datetime',
            'signed_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function hiring(): BelongsTo
    {
        return $this->belongsTo(Hiring::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
