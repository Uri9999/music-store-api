<?php

namespace App\Services;

use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\ArticleServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ArticleService implements ArticleServiceInterface
{
    protected $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
