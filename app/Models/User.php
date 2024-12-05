<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, FullTextSearch, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'gender',
        'dob',
        'status',
        'verification_token',
        'expires_at',
        'role_id',
        'password',
        'commission_rate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $fullTextColumns = ['name', 'email'];

    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LOCKED = 2;

    const LIST_STATUS = [
        self::STATUS_DISABLE,
        self::STATUS_ACTIVE,
        self::STATUS_LOCKED,
    ];

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;

    const REGISTER_VERIFY_EXPIRED = 1440; // unit minute
    const TOKEN_FORGOT_PASSWORD_EXPIRED = 10; // unit minute

    const MEDIA_AVATAR = 'avatar';

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function tabs(): HasMany
    {
        return $this->hasMany(Tab::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Một user gửi nhiều yêu cầu tạo tab.
     */
    public function tabRequests(): HasMany
    {
        return $this->hasMany(RequestTab::class);
    }

    /**
     * Một user nhận nhiều yêu cầu tab.
     */
    public function receiveTabRequests(): HasMany
    {
        return $this->hasMany(RequestTab::class, 'receiver_id');
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDisable(): bool
    {
        return $this->status == self::STATUS_DISABLE;
    }

    public function isAdmin(): bool
    {
        return $this->role_id == Role::ROLE_ADMIN;
    }

    public function isAffiliate(): bool
    {
        return $this->role_id == Role::ROLE_AFFILIATE;
    }

    public function isStatusActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }
}
