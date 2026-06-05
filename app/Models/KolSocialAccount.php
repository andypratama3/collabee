<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolSocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'kol_profile_id',
        'platform',
        'username',
        'profile_url',
        'followers_count',
        'following_count',
        'engagement_rate',
        'avg_likes',
        'avg_comments',
        'avg_views',
        'is_verified',
        'is_primary',
        'last_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'engagement_rate' => 'decimal:2',
            'is_verified' => 'boolean',
            'is_primary' => 'boolean',
            'last_synced_at' => 'datetime',
        ];
    }

    public function kolProfile(): BelongsTo
    {
        return $this->belongsTo(KolProfile::class);
    }
}
