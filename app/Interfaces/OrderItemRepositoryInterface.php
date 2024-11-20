<?php

namespace App\Interfaces;

use App\Models\RequestTab;
use Prettus\Repository\Contracts\RepositoryInterface;

interface OrderItemRepositoryInterface extends RepositoryInterface
{
    public function insert($data): void;
}
