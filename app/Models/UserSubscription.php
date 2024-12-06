<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserSubscription extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['status', 'subscription_id', 'user_id', 'meta', 'start_date', 'end_date', 'approver_id', 'approval_date', 'rejector_id', 'note'];

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

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function rejector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejector_id');
    }
}
