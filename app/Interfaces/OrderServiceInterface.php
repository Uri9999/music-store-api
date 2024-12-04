<?php

namespace App\Interfaces;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface OrderServiceInterface
{
    public function store(Request $request): void;
    public function show(int $id): ?Order;
    public function getMyOrder(Request $request);
    public function index(Request $request): LengthAwarePaginator;
    public function approval(int $id, Request $request): void;
    public function cancel(int $id, Request $request): void;
}
