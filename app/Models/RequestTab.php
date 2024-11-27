<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestTab extends Model
{
    use HasFactory, SoftDeletes, FullTextSearch;

    protected $fillable = [
        'user_id',
        'name',
        'author',
        'status',
        'receiver_id',
    ];

    const STATUS_DEFAULT = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;

    protected $fullTextColumns = ['name'];

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
