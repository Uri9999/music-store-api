<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tab extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'author',
        'price',
        'category_id'
    ];


    /**
     * Một tab thuộc về một user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Một tab thuộc về một category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
