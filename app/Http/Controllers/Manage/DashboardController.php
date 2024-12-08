<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Interfaces\DashboardServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected DashboardServiceInterface $service;

    public function __construct(DashboardServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getCount(Request $request): JsonResponse
    {
        $data = [
            'user_count' => $this->service->getCountUser(),
            'order_count' => $this->service->getCountOrder(),
            'tab_count' => $this->service->getCountTab(),
            'tab_revenue' => $this->service->getTabRevenue(),
            'subscription_revenue' => $this->service->getSubscriptionRevenue(),
        ];

        return ApiResponseService::success($data);
    }
}
