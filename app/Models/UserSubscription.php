<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'subscription_id', 'user_id', 'meta', 'start_date', 'end_date'];

    protected $casts = [
        'meta' => 'json',
    ];

    const MEDIA_SUBSCRIPTION_BILL = 'subscription-bill';

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
