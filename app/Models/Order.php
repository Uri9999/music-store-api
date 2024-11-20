<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'type', 'total_price', 'note', 'meta'];

    protected $casts = [
        'meta' => 'json',
    ];

    const STATUS_CREATED = 1;
    const STATUS_PENDING = 2;
    const STATUS_PAYMENT_SUCCESS = 3;

    const TYPE_TAB = 1;
    const TYPE_SUBSCRIPTION = 2;
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
