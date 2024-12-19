<?php

namespace App\Services;

use App\Interfaces\DeviceTokenRepositoryInterface;
use App\Interfaces\DeviceTokenServiceInterface;

class DeviceTokenService implements DeviceTokenServiceInterface
{
    protected DeviceTokenRepositoryInterface $repository;

    public function __construct(DeviceTokenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
