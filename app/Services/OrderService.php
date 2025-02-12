<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Exceptions\OrderException;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Jobs\CreateNotification;
use App\Mail\OrderCreatedEmail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

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
            $metaOrder = $tabs->map(function ($tab) {
                return [
                    'id' => $tab->id,
                    'name' => $tab->name,
                    'price' => $tab->price,
                ];
            })->toArray();
            // $totalPrice = $tabs->sum(fn($item) => ($item->price));
            $totalPrice = 0;
            foreach ($tabs as $tab) {
                $price = $tab->discount_money != null ? $tab->discount_money : $tab->price;
                $totalPrice += $price;
            }
            $userId = $user->getKey();
            $order = $this->repository->create([
                'user_id' => $userId,
                'status' => Order::STATUS_CREATED,
                'type' => Order::TYPE_TAB,
                'total_price' => $totalPrice,
                'note' => $request->get('note'),
                'meta' => $metaOrder
            ]);
            if ($request->file('bill')) {
                $media = $order->addMediaFromRequest('bill')->toMediaCollection(Order::MEDIA_BILL);
            }

            $orderItems = [];
            foreach ($tabs as $tab) {
                $orderItems[] = [
                    'order_id' => $order->getKey(),
                    'tab_id' => $tab->getKey(),
                    'user_id' => $tab->user_id,
                    'price' => $tab->discount_money != null ? $tab->discount_money : $tab->price,
                    'meta' => json_encode([
                        'name' => $tab->name,
                        'price' => $tab->price,
                        'discount_money' => $tab->discount_money,
                    ])
                ];
            }

            $this->orderItemRepository->insert($orderItems);
            $this->cartRepository->whereIn('tab_id', $tabIds)->where('user_id', $userId)->delete();

            CreateNotification::createOrder($order);
            Mail::to($user->email)->send(new OrderCreatedEmail($user->name, $order->getKey()));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw new OrderException();
        }
    }

    public function show(int $id): ?Order
    {
        $order = $this->repository->find($id)->load([
            'media' => function ($query) {
                $query->whereIn('collection_name', [Order::MEDIA_BILL]);
            },
            'orderItems',
            'user:id,name',
            'user.media' => function ($query) {
                $query->whereIn('collection_name', [User::MEDIA_AVATAR]);
            },
        ]);

        return $order;
    }

    public function getMyOrder(Request $request)
    {
        $userId = $request->user()->getKey();
        $orders = $this->repository->with([
            'orderItems',
            'orderItems.tab.reviewTabs' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }
        ])->where('user_id', $userId)->orderBy('created_at', 'DESC')->get();

        return $orders;
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->repository->with([
            'user:id,name',
            'approver:id,name',
            'canceller:id,name',
            'media' => function ($query) {
                $query->whereIn('collection_name', [Order::MEDIA_BILL]);
            },
            'orderItems',
        ]);
        if ($search = $request->get('search')) {
            $query = $query->whereHas('user', function (Builder $q) use ($search) {
                $q->fullTextSearch($search);
            });
        }
        if ($status = $request->get('status')) {
            $query = $query->whereIn('status', $status);
        }
        $orders = $query->orderBy('created_at', 'DESC')->paginate(10);

        return $orders;
    }

    public function approval(int $id, Request $request): void
    {
        $order = $this->repository->update(['status' => Order::STATUS_COMPLETED, 'approver_id' => $request->user()->getKey(), 'approval_date' => Carbon::today()], $id);

        CreateNotification::approvalOrder($order);
    }

    public function cancel(int $id, Request $request): void
    {
        $order = $this->repository->update(['status' => Order::STATUS_CANCEL, 'canceller_id' => $request->user()->getKey()], $id);

        CreateNotification::cancelOrder($order);
    }
}
