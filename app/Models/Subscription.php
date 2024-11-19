<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'duration_in_days',
        'price',
    ];

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}
