<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;

interface DashboardServiceInterface
{
    public function getCountUser(): int;
    public function getCountOrder(): int;
    public function getCountTab(): int;
    public function getTabRevenue(): int;
    public function getSubscriptionRevenue(): int;
    public function getUserStats(Request $request): Collection;
    public function getOrderStats(Request $request): Collection;
    public function getTabStats(Request $request): Collection;
}
