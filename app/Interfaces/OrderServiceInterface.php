<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface OrderServiceInterface
{
    public function store(Request $request): void;
}
