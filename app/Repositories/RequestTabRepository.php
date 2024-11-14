<?php

namespace App\Repositories;

use App\Interfaces\RequestTabRepositoryInterface;
use App\Models\RequestTab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository;

class RequestTabRepository extends BaseRepository implements RequestTabRepositoryInterface
{
    public function model(): string
    {
        return RequestTab::class;
    }
}
