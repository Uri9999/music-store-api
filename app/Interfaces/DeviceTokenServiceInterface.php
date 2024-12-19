<?php

namespace App\Interfaces;

use App\Models\DeviceToken;

interface DeviceTokenServiceInterface
{
    public function store(array $attrs): DeviceToken;
    public function delete(int $userId): void;
    public function getByUserId(int $userId): ?DeviceToken;
}
