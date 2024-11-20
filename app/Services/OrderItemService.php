<?php

namespace App\Services;

use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OrderItemServiceInterface;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;

class OrderItemService implements OrderItemServiceInterface
{
    protected $repository;

    public function __construct(OrderItemServiceInterface $repository)
    {
        $this->repository = $repository;
    }
}
