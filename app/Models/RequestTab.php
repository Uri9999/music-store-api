<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTab extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'receiver_id',
    ];

    const STATUS_DEFAULT = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;

    /**
     * Yêu cầu thuộc về người tạo.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Yêu cầu có người thực hiện (receiver).
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
