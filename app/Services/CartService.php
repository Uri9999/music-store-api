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

    public function getByUserId(int $userId): Collection
    {
        return $this->repository->where('user_id', $userId)->with(['user:id,name', 'tab', 'tab.category:id,name'])->get();
    }

    public function getCountByUserId(int $userId): int
    {
        return $this->repository->where('user_id', $userId)->count();
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
