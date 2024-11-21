<?php

namespace App\Services;

use App\Interfaces\OrderItemServiceInterface;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderItemService implements OrderItemServiceInterface
{
    protected OrderRepositoryInterface $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
