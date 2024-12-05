<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserSubscriptionRepositoryInterface;
use App\Interfaces\UserSubscriptionServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserSubscriptionService implements UserSubscriptionServiceInterface
{
    protected UserSubscriptionRepositoryInterface $repository;

    public function __construct(UserSubscriptionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

}
