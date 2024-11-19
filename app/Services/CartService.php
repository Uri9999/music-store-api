<?php

namespace App\Services;

use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CartServiceInterface;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;

class CartService implements CartServiceInterface
{
    protected $repository;

    public function __construct(CartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): Collection
    {
        return $this->repository->with(['user:id,name', 'tab'])->get();
    }

    public function store(array $attrs): Cart
    {
        $cart = $this->repository->create($attrs);

        return $cart;
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
