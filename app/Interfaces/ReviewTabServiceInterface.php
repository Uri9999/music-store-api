<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ReviewTabServiceInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function disable(int $id): void;
    public function enable(int $id): void;
}
