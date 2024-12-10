<?php

namespace App\Repositories;

use App\Interfaces\ReviewTabRepositoryInterface;
use App\Models\ReviewTab;
use Prettus\Repository\Eloquent\BaseRepository;

class ReviewTabRepository extends BaseRepository implements ReviewTabRepositoryInterface
{
    public function model(): string
    {
        return ReviewTab::class;
    }
}
