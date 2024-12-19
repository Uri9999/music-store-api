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

    const TYPE_1 = 1;
    const TYPE_2 = 2;
    const TYPE_3 = 3;

    const STATUS_UNSENT = 0;
    const STATUS_SENT = 1;
    const STATUS_READ = 2;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
