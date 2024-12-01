<?php

namespace App\Repositories;

use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use Prettus\Repository\Eloquent\BaseRepository;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{
    public function model(): string
    {
        return Article::class;
    }
}
