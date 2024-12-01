<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory, FullTextSearch;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'status',
        'type',
    ];

    protected $fullTextColumns = ['title'];

    const TYPE_TUTORIAL = 1;
    const TYPE_POLICY = 2;

    const STATUS_DRAFT = 1;
    const STATUS_PUBLIC = 2;
    const STATUS_LOCK = 3;

    public function role(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
