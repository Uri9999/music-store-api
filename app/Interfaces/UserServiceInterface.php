<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function index(Request $request): LengthAwarePaginator;
}
