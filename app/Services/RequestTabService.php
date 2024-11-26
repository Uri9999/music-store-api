<?php

namespace App\Services;

use App\Interfaces\RequestTabServiceInterface;
use App\Interfaces\RequestTabRepositoryInterface;
use App\Models\RequestTab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class RequestTabService implements RequestTabServiceInterface
{
    protected RequestTabRepositoryInterface $requestTabRepository;

    public function __construct(RequestTabRepositoryInterface $requestTabRepository)
    {
        $this->requestTabRepository = $requestTabRepository;
    }
    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->requestTabRepository->with(['user:id,name', 'receiver:id,name']);
        if ($search = $request->get('search')) {
            $query = $query->fullTextSearch($search);
        }
        $requestTabs = $query->paginate(10);

        return $requestTabs;
    }

    public function getById(int $id): RequestTab
    {
        return $this->requestTabRepository->find($id);
    }

    public function getCreatedByMy(int $userId)
    {
        return $this->requestTabRepository->with('receiver:id,name')->where('user_id', $userId)->get();
    }

    public function getByReceiverId(int $receiverId): LengthAwarePaginator
    {
        return $this->requestTabRepository->where('receiver_id', $receiverId)->paginate(config('app.paginate'));
    }

    public function create(array $data): RequestTab
    {
        return $this->requestTabRepository->create($data);
    }

    public function update(RequestTab $requestTab, array $data): RequestTab
    {
        return $this->requestTabRepository->update($data, $requestTab->getKey());
    }

    public function statusUpdate(RequestTab $requestTab, int $status): RequestTab
    {
        return $this->requestTabRepository->update(['status', $status], $requestTab);
    }

    public function delete(RequestTab $requestTab): bool
    {
        return $this->requestTabRepository->delete($requestTab->getKey());
    }
}
