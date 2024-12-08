<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StatsRequest;
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
            'user_count' => $this->service->getCountUser($request),
            'order_count' => $this->service->getCountOrder($request),
            'tab_count' => $this->service->getCountTab($request),
            'tab_revenue' => $this->service->getTabRevenue($request),
            'subscription_revenue' => $this->service->getSubscriptionRevenue($request),
        ];

        return ApiResponseService::success($data);
    }

    public function getUserStats(StatsRequest $request): JsonResponse
    {
        $resource = $this->service->getUserStats($request);
        $months = range(1, 12);
        $data = [];
        foreach ($months as $month) {
            $existingData = $resource->firstWhere('month', $month);
            $data[] = $existingData ? $existingData->count : 0;
        }
        $response = [
            'year' => $request->get('year'),
            'months' => $months,
            'data' => $data
        ];

        return ApiResponseService::success($response);
    }

    public function getOrderStats(StatsRequest $request): JsonResponse
    {
        $resource = $this->service->getOrderStats($request);
        $months = range(1, 12);
        $data = [];
        foreach ($months as $month) {
            $existingData = $resource->firstWhere('month', $month);
            $data[] = $existingData ? $existingData->count : 0;
        }
        $response = [
            'year' => $request->get('year'),
            'months' => $months,
            'data' => $data
        ];

        return ApiResponseService::success($response);
    }

    public function getTabStats(StatsRequest $request): JsonResponse
    {
        $resource = $this->service->getTabStats($request);
        $months = range(1, 12);
        $data = [];
        foreach ($months as $month) {
            $existingData = $resource->firstWhere('month', $month);
            $data[] = $existingData ? $existingData->count : 0;
        }
        $response = [
            'year' => $request->get('year'),
            'months' => $months,
            'data' => $data
        ];

        return ApiResponseService::success($response);
    }
}
