<?php

namespace App\Services;

use App\Interfaces\RequestTabServiceInterface;
use App\Interfaces\RequestTabRepositoryInterface;
use App\Models\RequestTab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RequestTabService implements RequestTabServiceInterface
{
    protected RequestTabRepositoryInterface $requestTabRepository;

    public function __construct(RequestTabRepositoryInterface $requestTabRepository)
    {
        $this->requestTabRepository = $requestTabRepository;
    }
    public function index(): LengthAwarePaginator
    {
        return $this->requestTabRepository->paginate(config('app.paginate'));
    }

    public function getById(int $id): RequestTab
    {
        return $this->requestTabRepository->find($id);
    }

    public function getCreatedByMy(int $userId): LengthAwarePaginator
    {
        return $this->requestTabRepository->where('user_id', $userId)->paginate(config('app.paginate'));
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
