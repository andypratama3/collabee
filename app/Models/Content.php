<?php

namespace App\Models;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_id',
        'kol_profile_id',
        'brand_profile_id',
        'title',
        'caption',
        'media_files',
        'notes',
        'status',
        'submitted_at',
        'approved_at',
        'deadline_at',
        'post_url',
        'posted_at',
    ];

    protected function casts(): array
    {
        return [
            'media_files' => 'array',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'deadline_at' => 'datetime',
            'posted_at' => 'datetime',
            'status' => ContentStatus::class,
        ];
    }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }

    public function kolProfile(): BelongsTo
    {
        return $this->belongsTo(KolProfile::class);
    }

    public function brandProfile(): BelongsTo
    {
        return $this->belongsTo(BrandProfile::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ContentRevision::class);
    }
}
