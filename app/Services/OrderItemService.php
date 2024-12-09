<?php

namespace App\Services;

use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderItemServiceInterface;

class OrderItemService implements OrderItemServiceInterface
{
    protected OrderItemRepositoryInterface $repository;

    public function __construct(OrderItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function checkBoughtTab(int $tabId, int $userId): bool
    {
        $boughtStatus = false;
        $orderItem = $this->repository->where('tab_id', $tabId)->whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->first();
        if ($orderItem) {
            $boughtStatus = true;
        }

        return $boughtStatus;
    }
}
