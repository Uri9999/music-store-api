<?php

namespace App\Interfaces;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface CartServiceInterface
{
    public function getByUserId(int $userId): Collection;
    public function getCountByUserId(int $userId): int;
    public function store(array $attrs): Cart;
    public function delete(int $id): void;
    public function checkout(Request $request): void;
}
