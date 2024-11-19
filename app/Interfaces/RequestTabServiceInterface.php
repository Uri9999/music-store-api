<?php

namespace App\Interfaces;

use App\Models\RequestTab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RequestTabServiceInterface
{
    public function index(): LengthAwarePaginator;

    public function getById(int $id): RequestTab;

    public function getCreatedByMy(int $userId);

    public function getByReceiverId(int $receiverId): LengthAwarePaginator;

    public function create(array $data): RequestTab;

    public function update(RequestTab $requestTab, array $data): RequestTab;

    public function statusUpdate(RequestTab $requestTab, int $status): RequestTab;

    public function delete(RequestTab $requestTab): bool;
}
