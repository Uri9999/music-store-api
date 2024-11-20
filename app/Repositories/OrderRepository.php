<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function model(): string
    {
        return Order::class;
    }
}
