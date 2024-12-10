<?php

namespace App\Services;

use App\Interfaces\ReviewTabRepositoryInterface;
use App\Interfaces\ReviewTabServiceInterface;


class ReviewTabService implements ReviewTabServiceInterface
{
    protected ReviewTabRepositoryInterface $repository;

    public function __construct(ReviewTabRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
