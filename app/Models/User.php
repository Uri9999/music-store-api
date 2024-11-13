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
        return $this->hasMany(TabRequest::class);
    }

    /**
     * Một user nhận nhiều yêu cầu tab.
     */
    public function receiveTabRequests()
    {
        return $this->hasMany(TabRequest::class, 'receiver_id');
    }
}
