<?php

namespace App\Services;

use App\Interfaces\ReviewTabRepositoryInterface;
use App\Interfaces\ReviewTabServiceInterface;
use App\Models\ReviewTab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ReviewTabService implements ReviewTabServiceInterface
{
    protected ReviewTabRepositoryInterface $repository;

    public function __construct(ReviewTabRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->repository->with(['user:id,name', 'tab:id,name']);
        if ($search = $request->get('search')) {
            $query = $query->whereHas('user', function (Builder $q) use ($search) {
                $q->fullTextSearch($search);
            });
        }
        return $query->paginate(10);
    }

    public function disable(int $id): void
    {
        $this->repository->update(['status' => ReviewTab::STATUS_DISABLE], $id);
    }

    public function enable(int $id): void
    {
        $this->repository->update(['status' => ReviewTab::STATUS_ENABLE], $id);
    }
}
