<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Order\StoreRequest;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $this->service->store($request);

        return ApiResponseService::success(null, 'Tạo order thành công');
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->service->show($id);

        return ApiResponseService::success($order);
    }

    public function getMyOrder(Request $request)
    {
        $orders = $this->service->getMyOrder($request);

        return ApiResponseService::success($orders);
    }
}
