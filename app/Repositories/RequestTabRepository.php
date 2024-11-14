<?php

namespace App\Repositories;

use App\Interfaces\RequestTabRepositoryInterface;
use App\Models\RequestTab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RequestTabRepository implements RequestTabRepositoryInterface
{
    public function index(): LengthAwarePaginator
    {
        return RequestTab::paginate(config('app.paginate'));
    }

    public function getById(int $id): RequestTab
    {
        return RequestTab::findOrFail($id);
    }

    public function getCreatedByMy($userId): LengthAwarePaginator
    {
        return RequestTab::where('user_id', $userId)->paginate(config('app.paginate'));
    }

    public function getByReceiverId(int $receiverId): LengthAwarePaginator
    {
        return RequestTab::where('receiver_id', $receiverId)->paginate(config('app.paginate'));
    }

    public function create(array $data): RequestTab
    {
        return RequestTab::create($data);
    }

    public function update(RequestTab $requestTab, array $data): RequestTab
    {
        $requestTab->update($data);

        return $requestTab;
    }

    public function delete(RequestTab $requestTab): bool
    {
        $requestTab->delete();

        return true;
    }
}
