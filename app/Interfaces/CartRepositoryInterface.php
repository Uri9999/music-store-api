<?php

namespace App\Interfaces;

use App\Models\Category;
use Prettus\Repository\Contracts\RepositoryInterface;

interface CartRepositoryInterface extends RepositoryInterface
{
    public function deleteByIds(array $ids): void;
}
