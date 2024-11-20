<?php

namespace App\Services;

use App\Interfaces\OrderServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderService implements OrderServiceInterface
{
    protected $repository;

    public function __construct(OrderServiceInterface $repository)
    {
        $this->repository = $repository;
    }
}
