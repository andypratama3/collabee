<?php

namespace App\Models;

use App\Enums\HiringStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hiring extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'brand_profile_id',
        'kol_profile_id',
        'initiated_by',
        'status',
        'message',
        'proposed_budget',
        'agreed_budget',
        'note',
        'rejected_reason',
        'accepted_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'proposed_budget' => 'decimal:2',
            'agreed_budget' => 'decimal:2',
            'accepted_at' => 'datetime',
            'expires_at' => 'datetime',
            'status' => HiringStatus::class,
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function brandProfile(): BelongsTo
    {
        return $this->belongsTo(BrandProfile::class);
    }

    public function kolProfile(): BelongsTo
    {
        return $this->belongsTo(KolProfile::class);
    }

    public function chatRoom(): HasOne
    {
        return $this->hasOne(ChatRoom::class);
    }

    public function agreement(): HasOne
    {
        return $this->hasOne(Agreement::class);
    }

    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class);
    }

    public function dispute(): HasOne
    {
        return $this->hasOne(Dispute::class);
    }
}
