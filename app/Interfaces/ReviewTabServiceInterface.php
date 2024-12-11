<?php

namespace App\Interfaces;

use App\Models\ReviewTab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ReviewTabServiceInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function disable(int $id): void;
    public function enable(int $id): void;
    public function store(array $attrs): ReviewTab;
}
