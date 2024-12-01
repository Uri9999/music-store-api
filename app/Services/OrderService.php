<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Exceptions\OrderException;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService implements OrderServiceInterface
{
    protected OrderRepositoryInterface $repository;
    protected TabRepositoryInterface $tabRepository;
    protected OrderItemRepositoryInterface $orderItemRepository;
    protected CartRepositoryInterface $cartRepository;

    public function __construct(OrderRepositoryInterface $repository, TabRepositoryInterface $tabRepository, OrderItemRepositoryInterface $orderItemRepository, CartRepositoryInterface $cartRepository)
    {
        $this->repository = $repository;
        $this->tabRepository = $tabRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->cartRepository = $cartRepository;
    }

    public function store(Request $request): void
    {
        try {
            $user = $request->user();
            $tabIds = $request->get('tab_ids');
            $tabs = $this->tabRepository->whereIn('id', $tabIds)->get();
            $totalPrice = $tabs->sum(fn($item) => $item->price);
            $userId = $user->getKey();
            $order = $this->repository->create([
                'user_id' => $userId,
                'status' => Order::STATUS_CREATED,
                'type' => Order::TYPE_TAB,
                'total_price' => $totalPrice,
                'note' => $request->get('note'),
                'meta' => [
                    'test' => 'ok'
                ]
            ]);
            if ($request->file('bill')) {
                $media = $order->addMediaFromRequest('bill')->toMediaCollection(Order::MEDIA_BILL);
            }

            $orderItems = [];
            foreach ($tabs as $tab) {
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
            $this->cartRepository->deleteByIds($tabIds);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw new OrderException();
        }
    }

    public function show(int $id): ?Order
    {
        $order = $this->repository->find($id)->load('media');

        return $order;
    }

    public function getMyOrder(Request $request)
    {
        $orders = $this->repository->with('orderItems')->where('user_id', $request->user()->getKey())->orderBy('created_at', 'DESC')->get();

        return $orders;
    }

    public function index(Request $request): LengthAwarePaginator
    {

        $query = $this->repository->with([
            'user:id,name',
            'media' => function ($query) {
                $query->whereIn('collection_name', [Order::MEDIA_BILL]);
            }
        ]);
        if ($search = $request->get('search')) {
            $query = $query->whereHas('user', function (Builder $q) use ($search) {
                $q->fullTextSearch($search);
            });
        }
        if ($status = $request->get('status')) {
            $query = $query->whereIn('status', $status);
        }
        $orders = $query->paginate(10);

        return $orders;
    }
}
