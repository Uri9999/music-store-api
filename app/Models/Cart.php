<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tab_id', 'meta'];

    protected $casts = [
        'meta' => 'json',
    ];

    public function tab()
    {
        return $this->belongsTo(Tab::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
