<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'start_date',
        'end_date',
        'status',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;


    /**
     * Relationship: A user_subscription belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A user_subscription belongs to a subscription.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Check if the subscription is active.
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE && $this->end_date >= now();
    }
}
