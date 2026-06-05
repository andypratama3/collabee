<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'hiring_id',
        'brand_user_id',
        'kol_user_id',
        'last_message_at',
        'brand_unread',
        'kol_unread',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function hiring(): BelongsTo
    {
        return $this->belongsTo(Hiring::class);
    }

    public function brandUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'brand_user_id');
    }

    public function kolUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kol_user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
