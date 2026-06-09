<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BrandProfile extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia, Searchable;

    protected $fillable = [
        'user_id',
        'brand_name',
        'description',
        'industry',
        'website',
        'target_market',
        'location',
        'logo',
        'banner',
        'total_campaigns',
        'total_spent',
        'rating_avg',
        'rating_count',
        'profile_completed_at',
    ];

    protected function casts(): array
    {
        return [
            'target_market' => 'array',
            'total_spent' => 'decimal:2',
            'rating_avg' => 'decimal:2',
            'profile_completed_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('brand_name')
            ->saveSlugsTo('slug');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function hirings(): HasMany
    {
        return $this->hasMany(Hiring::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brand_logo')
            ->singleFile();

        $this->addMediaCollection('brand_banner')
            ->singleFile();
    }
}
