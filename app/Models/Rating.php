<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'hiring_id',
        'rater_id',
        'rated_id',
        'type',
        'communication',
        'professionalism',
        'quality',
        'timeliness',
        'overall',
        'review',
    ];

    protected function casts(): array
    {
        return [
            'overall' => 'decimal:2',
            'communication' => 'integer',
            'professionalism' => 'integer',
            'quality' => 'integer',
            'timeliness' => 'integer',
        ];
    }

    public function hiring(): BelongsTo
    {
        return $this->belongsTo(Hiring::class);
    }

    public function rater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rater_id');
    }

    public function rated(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rated_id');
    }
}
