<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\UserSubscriptionServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class UserSubscriptionController extends Controller
{
    protected UserSubscriptionServiceInterface $service;

    public function __construct(UserSubscriptionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }

    public function approve(Request $request, int $id): JsonResponse
    {
        $this->service->approve($id, $request->user()->getKey());

        return ApiResponseService::success(null, 'Phê duyệt thành công.');
    }

    public function reject(Request $request, int $id): JsonResponse
    {
        $this->service->reject($id, $request->user()->getKey());

        return ApiResponseService::success(null, 'Hủy thành công.');
    }
}
