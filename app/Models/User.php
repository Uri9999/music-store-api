<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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

    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;

    const REGISTER_VERIFY_EXPIRED = 1440; // unit minute
    const TOKEN_FORGOT_PASSWORD_EXPIRED = 10; // unit minute

    /**
     * Một user thuộc về một role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function tabs()
    {
        return $this->hasMany(Tab::class);
    }

    /**
     * Một user gửi nhiều yêu cầu tạo tab.
     */
    public function tabRequests()
    {
        return $this->hasMany(RequestTab::class);
    }

    /**
     * Một user nhận nhiều yêu cầu tab.
     */
    public function receiveTabRequests()
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
}
