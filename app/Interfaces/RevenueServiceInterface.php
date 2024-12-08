<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface RevenueServiceInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function show(int $id, Request $request): User;
}
