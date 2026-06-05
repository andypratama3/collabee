<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class KolProfile extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'user_id',
        'slug',
        'display_name',
        'bio',
        'category',
        'sub_categories',
        'location',
        'gender',
        'date_of_birth',
        'languages',
        'total_followers',
        'avg_engagement_rate',
        'total_campaigns_done',
        'total_earned',
        'wallet_balance',
        'pending_balance',
        'rating_avg',
        'rating_count',
        'is_open_for_work',
        'min_budget',
        'profile_completed_at',
    ];

    protected function casts(): array
    {
        return [
            'sub_categories' => 'array',
            'languages' => 'array',
            'total_earned' => 'decimal:2',
            'wallet_balance' => 'decimal:2',
            'pending_balance' => 'decimal:2',
            'rating_avg' => 'decimal:2',
            'avg_engagement_rate' => 'decimal:2',
            'min_budget' => 'decimal:2',
            'date_of_birth' => 'date',
            'is_open_for_work' => 'boolean',
            'profile_completed_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('display_name')
            ->saveSlugsTo('slug');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(KolSocialAccount::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(KolPortfolio::class);
    }

    public function rateCards(): HasMany
    {
        return $this->hasMany(KolRateCard::class);
    }

    public function hirings(): HasMany
    {
        return $this->hasMany(Hiring::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function bankAccount(): HasOne
    {
        return $this->hasOne(KolBankAccount::class);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(KolWithdrawal::class);
    }
}
