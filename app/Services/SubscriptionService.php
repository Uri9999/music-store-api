<?php

namespace App\Services;

use App\Interfaces\SubscriptionRepositoryInterface;
use App\Interfaces\SubscriptionServiceInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionService implements SubscriptionServiceInterface
{
    protected SubscriptionRepositoryInterface $repository;

    public function __construct(SubscriptionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): Collection
    {
        return $this->repository->get();
    }
}
