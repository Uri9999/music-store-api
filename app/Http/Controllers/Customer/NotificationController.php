<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Interfaces\NotificationServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    protected NotificationServiceInterface $service;

    public function __construct(NotificationServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getMyNotify(Request $request): JsonResponse
    {
        $notices = $this->service->getMyNotify($request);

        return ApiResponseService::paginate($notices, 'Đánh giá thành công.', 200, NotificationResource::class);
    }

    public function countNotReadYet(Request $request): JsonResponse
    {
        $count = $this->service->countNotReadYet($request);

        return ApiResponseService::success($count);
    }
}
