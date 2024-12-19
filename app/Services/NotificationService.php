<?php

namespace App\Services;

use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationServiceInterface;

class NotificationService implements NotificationServiceInterface
{
    protected NotificationRepositoryInterface $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
