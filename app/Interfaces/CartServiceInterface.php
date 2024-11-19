<?php

namespace App\Interfaces;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;

interface CartServiceInterface
{
    public function index(): Collection;
    public function store(array $attrs): Cart;
    public function delete(int $id): void;
}
