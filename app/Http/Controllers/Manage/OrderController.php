<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderIndexRequest;
use App\Http\Resources\OrderResource;
use App\Interfaces\OrderServiceInterface;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(OrderIndexRequest $request): JsonResponse
    {
        $paginator = $this->service->index($request);


        return ApiResponseService::paginate($paginator, '', 200, OrderResource::class);
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->service->show($id);
        $resource = new OrderResource($order);

        return ApiResponseService::success($resource);
    }

    public function approval(Request $request, int $id): JsonResponse
    {
        $this->service->approval($id, $request);

        return ApiResponseService::success(null, 'Đơn hàng đã hoàn thành.');
    }

    public function cancel(Request $request, int $id): JsonResponse
    {
        $this->service->cancel($id, $request);

        return ApiResponseService::success(null, 'Đã hủy đơn hàng.');
    }
}
