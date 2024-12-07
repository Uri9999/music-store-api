<?php

namespace App\Services;

use App\Interfaces\RevenueServiceInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Order;
use App\Models\Role;
use App\Models\UserSubscription;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');

        $query = $this->userRepository;
        if ($search) {
            $query = $query->fullTextSearch($search);
        }
        $query = $query
            ->whereIn('role_id', [Role::ROLE_STAFF, Role::ROLE_AFFILIATE, Role::ROLE_ADMIN])
            ->with([
                'role:id,name',
            ])
            ->withSum([
                'orderItems' => function ($q) use ($startDate, $endDate) {
                    $q->whereHas('order', function ($subQuery) use ($startDate, $endDate) {
                        $subQuery->where('status', Order::STATUS_COMPLETED)
                            ->when($startDate, function ($query, string $startDate) {
                                $query->where('approval_date', '>=', $startDate);
                            })
                            ->when($endDate, function ($query, string $endDate) {
                                $query->where('approval_date', '<=', $endDate);
                            });
                    });
                }
            ], 'price')
            ->withSum([
                'userSubscriptions' => function ($q) use ($startDate, $endDate) {
                    $q->where('status', UserSubscription::STATUS_APPROVED)
                        ->when($startDate, function ($query, string $startDate) {
                            $query->where('approval_date', '>=', $startDate);
                        })
                        ->when($endDate, function ($query, string $endDate) {
                            $query->where('approval_date', '<=', $endDate);
                        });
                }
            ], 'price');

        $users = $query->paginate(10);

        return $users;
    }
}
