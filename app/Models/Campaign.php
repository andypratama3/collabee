<?php

namespace App\Models;

use App\Enums\CampaignStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Campaign extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'brand_profile_id',
        'slug',
        'title',
        'description',
        'brief',
        'objectives',
        'platforms',
        'content_types',
        'kol_category',
        'min_followers',
        'max_followers',
        'min_engagement',
        'target_gender',
        'location',
        'budget_total',
        'budget_per_kol',
        'kol_slots',
        'kol_filled',
        'start_date',
        'end_date',
        'deadline_apply',
        'status',
        'is_featured',
        'views_count',
        'applications_count',
    ];

    protected function casts(): array
    {
        return [
            'objectives' => 'array',
            'platforms' => 'array',
            'content_types' => 'array',
            'budget_total' => 'decimal:2',
            'budget_per_kol' => 'decimal:2',
            'min_engagement' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'deadline_apply' => 'date',
            'is_featured' => 'boolean',
            'status' => CampaignStatus::class,
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function brandProfile(): BelongsTo
    {
        return $this->belongsTo(BrandProfile::class);
    }

    public function hirings(): HasMany
    {
        return $this->hasMany(Hiring::class);
    }

    public function hiringApplications(): HasMany
    {
        return $this->hasMany(HiringApplication::class);
    }
}
