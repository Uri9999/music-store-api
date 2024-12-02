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
}
