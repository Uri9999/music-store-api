<?php

namespace App\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

interface DashboardServiceInterface
{
    public function getCountUser(): int;
    public function getCountOrder(): int;
    public function getCountTab(): int;
    public function getTabRevenue(): int;
    public function getSubscriptionRevenue(): int;
}
