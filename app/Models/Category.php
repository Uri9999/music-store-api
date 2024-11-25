<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, FullTextSearch;

    protected $fillable = ['name', 'description', 'parent_id'];

    protected $fullTextColumns = ['name'];
    /**
     * Quan hệ cha - con (một danh mục có nhiều danh mục con).
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Quan hệ cha - con (một danh mục thuộc về một danh mục cha).
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function tabs()
    {
        return $this->hasMany(Tab::class);
    }

}
