<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasApiTokens, HasFactory, HasRoles, InteractsWithMedia, LogsActivity, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'user_type',
        'avatar',
        'is_active',
        'is_verified',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'last_login_at' => 'datetime',
            'user_type' => UserRole::class,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'user_type', 'is_active'])
            ->logOnlyDirty();
    }

    public function brandProfile(): HasOne
    {
        return $this->hasOne(BrandProfile::class);
    }

    public function kolProfile(): HasOne
    {
        return $this->hasOne(KolProfile::class);
    }

    public function chatRoomsAsBrand(): HasMany
    {
        return $this->hasMany(ChatRoom::class, 'brand_user_id');
    }

    public function chatRoomsAsKol(): HasMany
    {
        return $this->hasMany(ChatRoom::class, 'kol_user_id');
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function platformReviews(): HasMany
    {
        return $this->hasMany(PlatformReview::class);
    }

    public function ratingsGiven(): HasMany
    {
        return $this->hasMany(Rating::class, 'rater_id');
    }

    public function ratingsReceived(): HasMany
    {
        return $this->hasMany(Rating::class, 'rated_id');
    }

    public function disputesRaised(): HasMany
    {
        return $this->hasMany(Dispute::class, 'raised_by');
    }

    public function disputesAgainst(): HasMany
    {
        return $this->hasMany(Dispute::class, 'against_id');
    }

    public function isBrand(): bool
    {
        return $this->user_type === UserRole::BRAND;
    }

    public function isKol(): bool
    {
        return $this->user_type === UserRole::KOL;
    }

    public function isAdmin(): bool
    {
        return $this->user_type === UserRole::ADMIN || $this->user_type === UserRole::SUPER_ADMIN;
    }

    public function isSuperAdmin(): bool
    {
        return $this->user_type === UserRole::SUPER_ADMIN;
    }
}
