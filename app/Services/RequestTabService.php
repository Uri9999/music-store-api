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
        if ($status = $request->get('status')) {
            $query = $query->whereIn('status', $status);
        }
        if ($receiverId = $request->get('user_id')) {
            $query = $query->where('receiver_id', $receiverId);
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

    public function create(array $data): RequestTab
    {
        return $this->requestTabRepository->create($data);
    }

    public function update(RequestTab $requestTab, array $data): RequestTab
    {
        return $this->requestTabRepository->update($data, $requestTab->getKey());
    }

    public function updateStatus(RequestTab $requestTab, int $status): RequestTab
    {
        return $this->requestTabRepository->update(['status' => $status], $requestTab->getKey());
    }

    public function delete(int $id): void
    {
        $this->requestTabRepository->delete($id);
    }
}
