<?php

namespace App\Services;

use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderItemServiceInterface;
use App\Models\Order;

class OrderItemService implements OrderItemServiceInterface
{
    protected OrderItemRepositoryInterface $repository;

    public function __construct(OrderItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function checkBoughtTab(int $tabId, int $userId): bool
    {
        $orderItem = $this->repository->where('tab_id', $tabId)->whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', Order::STATUS_COMPLETED);
        })->exists();

        return $orderItem;
    }
}
