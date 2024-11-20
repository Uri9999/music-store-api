<?php

namespace App\Repositories;

use App\Interfaces\OrderItemRepositoryInterface;
use App\Models\OrderItem;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
{
    public function model(): string
    {
        return OrderItem::class;
    }

    public function insert($data): void
    {
        $this->model->insert($data);
    }
}
