<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolPortfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'kol_profile_id',
        'title',
        'description',
        'media_type',
        'media_url',
        'external_link',
        'sort_order',
    ];

    public function kolProfile(): BelongsTo
    {
        return $this->belongsTo(KolProfile::class);
    }
}
