<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Interfaces\DeviceTokenServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    protected DeviceTokenServiceInterface $service;

    public function __construct(DeviceTokenServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(Request $request): JsonResponse
    {
        $attrs = [
            'name' => $request->userAgent(),
            'token' => $request->get('token'),
            'user_id' => $request->user()->getKey(),
        ];
        $device = $this->service->store($attrs);

        return ApiResponseService::success($device, 'ok');
    }
}
