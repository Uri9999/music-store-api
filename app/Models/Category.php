<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_id'];

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
