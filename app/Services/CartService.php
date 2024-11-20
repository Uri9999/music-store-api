<?php

namespace App\Services;

use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CartServiceInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CartService implements CartServiceInterface
{
    protected $repository;
    protected TabRepositoryInterface $tabRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected OrderItemRepositoryInterface $orderItemRepository;

    public function __construct(CartRepositoryInterface $repository, TabRepositoryInterface $tabRepository, OrderRepositoryInterface $orderRepository, OrderItemRepositoryInterface $orderItemRepository)
    {
        $this->repository = $repository;
        $this->tabRepository = $tabRepository;
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
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

    public function checkout(Request $request): void
    {
        $tabs = $this->tabRepository->whereIn('id', $request->get('tab_ids'))->get();
        $totalPrice = $tabs->sum(fn($item) => $item->price);
        $userId = $request->user()->getKey();
        $order = $this->orderRepository->create([
            'user_id' => $userId,
            'status' => Order::STATUS_PENDING,
            'type' => Order::TYPE_TAB,
            'total_price' => $totalPrice,
            'note' => $request->get('note'),
            'meta' => [
                'test' => 'ok'
            ]
        ]);

        $orderItems = [];
        foreach ($tabs as $key => $tab) {
            $orderItems[] = [
                'order_id' => $order->getKey(),
                'tab_id' => $tab->getKey(),
                'user_id' => $userId,
                'price' => $tab->price,
                'meta' => json_encode([
                    'name' => $tab->name,
                    'price' => $tab->price,
                ])
            ];
        }

        $this->orderItemRepository->insert($orderItems);
    }
}
