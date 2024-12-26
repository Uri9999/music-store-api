<?php
namespace App\Http\Controllers\Manage;

use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Revenue\RevenueIndexRequest;
use App\Http\Resources\OrderItemResource;
use App\Interfaces\OrderItemServiceInterface;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    protected OrderItemServiceInterface $service;

    public function __construct(OrderItemServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator, 'ok', 200, OrderItemResource::class);
    }

}

