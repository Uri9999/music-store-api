<?php

namespace App\Repositories;

use App\Interfaces\TabRepositoryInterface;
use App\Models\Tab;
use Prettus\Repository\Eloquent\BaseRepository;

class TabRepository extends BaseRepository implements TabRepositoryInterface
{
    public function model(): string
    {
        return Tab::class;
    }
}
