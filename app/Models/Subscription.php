<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'duration_in_days', 'price', 'description', 'feature'];

    protected $casts = [
        'feature' => 'json',
    ];
}
