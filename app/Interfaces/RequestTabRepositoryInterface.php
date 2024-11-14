<?php

namespace App\Interfaces;

use App\Models\RequestTab;

interface RequestTabRepositoryInterface
{
    public function index();

    public function getById(int $id);

    public function getCreatedByMy($userId);

    public function getByReceiverId(int $receiverId);

    public function create(array $data);

    public function update(RequestTab $requestTab, array $data);

    public function delete(RequestTab $requestTab);
}
