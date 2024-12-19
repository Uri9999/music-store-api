<?php

namespace App\Repositories;

use App\Interfaces\DeviceTokenRepositoryInterface;
use App\Models\DeviceToken;
use Prettus\Repository\Eloquent\BaseRepository;

class DeviceTokenRepository extends BaseRepository implements DeviceTokenRepositoryInterface
{
    public function model(): string
    {
        return DeviceToken::class;
    }
}
