<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'type',
        'user_id',
        'status',
        'send_at',
        'meta',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'meta' => 'json',
    ];

    const TYPE_CREATE_ORDER = 1;
    const TYPE_APPROVE_ORDER = 2;
    const TYPE_CANCEL_ORDER = 3;
    const TYPE_REGISTER_SUBSCRIPTION = 4;
    const TYPE_APPROVE_SUBSCRIPTION = 5;
    const TYPE_REJECT_ORDER = 6;

    const STATUS_UNSENT = 0;
    const STATUS_SENT = 1;
    const STATUS_READ = 2;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isStatusSent(): bool
    {
        return $this->status == self::STATUS_SENT;
    }
}
