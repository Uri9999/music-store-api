<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewTab extends Model
{
    protected $fillable = [
        'user_id',
        'tab_id',
        'rating',
        'comment',
        'status',
    ];

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tab(): BelongsTo
    {
        return $this->belongsTo(Tab::class);
    }
}
