<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;

interface DashboardServiceInterface
{
    public function getCountUser(Request $request): int;
    public function getCountOrder(Request $request): int;
    public function getCountTab(Request $request): int;
    public function getTabRevenue(Request $request): int;
    public function getSubscriptionRevenue(Request $request): int;
    public function getUserStats(Request $request): Collection;
    public function getOrderStats(Request $request): Collection;
    public function getTabStats(Request $request): Collection;
}
