<?php

namespace App\Interfaces;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface OrderServiceInterface
{
    public function store(Request $request): void;
    public function show(int $id): ?Order;
    public function getMyOrder(Request $request);
}
