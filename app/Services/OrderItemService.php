<?php

namespace App\Services;

use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderItemServiceInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->repository->with(['tab', 'user', 'order']);
        if ($userId = $request->get('user_id')) {
            $query = $query->whereHas('tab', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        if ($search = $request->get('search')) {
            $query = $query->whereHas('tab', function ($q) use ($search) {
                $q->fullTextSearch($search);
            });
        }
        $orderItems = $query->paginate(10);

        return $orderItems;
    }
}
