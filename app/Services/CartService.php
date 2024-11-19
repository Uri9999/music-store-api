<?php

namespace App\Services;

use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CartServiceInterface;

class CartService implements CartServiceInterface
{
    protected $repository;

    public function __construct(CartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
