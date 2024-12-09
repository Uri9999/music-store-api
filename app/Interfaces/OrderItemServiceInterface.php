<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface OrderItemServiceInterface
{
    public function checkBoughtTab(int $tabId, int $userId): bool;
}
