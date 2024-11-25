<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tab extends Model  implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'author',
        'price',
        'category_id',
        'youtobe_url',
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
