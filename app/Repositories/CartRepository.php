<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use Prettus\Repository\Eloquent\BaseRepository;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    public function model(): string
    {
        return Cart::class;
    }

    public function deleteByIds(array $ids): void
    {
        $this->model->whereIn('id', $ids)->delete();
    }
}
