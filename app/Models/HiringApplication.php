<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HiringApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'kol_profile_id',
        'proposed_budget',
        'message',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'proposed_budget' => 'decimal:2',
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function kolProfile(): BelongsTo
    {
        return $this->belongsTo(KolProfile::class);
    }
}
