<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const ROLE_ADMIN = 1;
    const ROLE_STAFF = 2;
    const ROLE_AFFILIATE = 3;
    const ROLE_USER = 4;

    /**
     * Một role có nhiều user.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
