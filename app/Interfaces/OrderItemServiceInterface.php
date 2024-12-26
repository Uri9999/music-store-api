<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderItemServiceInterface
{
    public function checkBoughtTab(int $tabId, int $userId): bool;
    public function index(Request $request): LengthAwarePaginator;
}
