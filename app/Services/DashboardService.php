<?php
namespace App\Services;

use App\Interfaces\DashboardServiceInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserSubscriptionRepositoryInterface;
use App\Models\Order;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardService implements DashboardServiceInterface
{
    protected UserRepositoryInterface $userRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected TabRepositoryInterface $tabRepository;
    protected OrderItemRepositoryInterface $orderItemRepository;
    protected UserSubscriptionRepositoryInterface $userSubscriptionRepository;

    public function __construct(UserRepositoryInterface $userRepository, OrderRepositoryInterface $orderRepository, TabRepositoryInterface $tabRepository, OrderItemRepositoryInterface $orderItemRepository, UserSubscriptionRepositoryInterface $userSubscriptionRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->tabRepository = $tabRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->userSubscriptionRepository = $userSubscriptionRepository;
    }

    public function getCountUser(): int
    {
        return $this->userRepository->count();
    }

    public function getCountOrder(): int
    {
        return $this->orderRepository->count();
    }

    public function getCountTab(): int
    {
        return $this->tabRepository->count();
    }

    public function getTabRevenue(): int
    {
        $sum = $this->orderItemRepository->whereHas('order', function ($query) {
            $query->where('status', Order::STATUS_COMPLETED);
        })->sum('price');

        return $sum;
    }

    public function getSubscriptionRevenue(): int
    {
        $sum = $this->userSubscriptionRepository->where('status', UserSubscription::STATUS_APPROVED)->sum('price');

        return $sum;
    }

    public function getUserStats(Request $request): Collection
    {
        $year = $request->get('year');
        $userStats = $this->userRepository->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->where('created_at', '>=', now()->subYear()) // Lấy dữ liệu trong 12 tháng
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month', 'asc')
            ->get();

        return $userStats;
    }

    public function getOrderStats(Request $request): Collection
    {
        $year = $request->get('year');
        $userStats = $this->orderRepository->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->where('created_at', '>=', now()->subYear()) // Lấy dữ liệu trong 12 tháng
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month', 'asc')
            ->get();

        return $userStats;
    }

    public function getTabStats(Request $request): Collection
    {
        $year = $request->get('year');
        $userStats = $this->tabRepository->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->where('created_at', '>=', now()->subYear()) // Lấy dữ liệu trong 12 tháng
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month', 'asc')
            ->get();

        return $userStats;
    }
}
