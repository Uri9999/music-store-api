<?php

namespace App\Services;

use App\Interfaces\RevenueServiceInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Order;
use App\Models\Role;
use App\Models\UserSubscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class RevenueService implements RevenueServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->userRepository
            // ->whereIn('role_id', [Role::ROLE_STAFF, Role::ROLE_AFFILIATE])
            ->with([
                'role:id,name',
            ])
            ->withSum([
                'orderItems' => function ($q) {
                    $q->whereHas('order', function ($subQuery) {
                        $subQuery->where('status', Order::STATUS_COMPLETED);
                    });
                }
            ], 'price')
            ->withSum([
                'userSubscriptions' => function ($q) {
                    $q->where('status', UserSubscription::STATUS_APPROVED);
                }
            ], 'price');

        $users = $query->paginate(10);

        return $users;
    }
}
