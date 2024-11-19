<?php

namespace App\Http\Controllers;

use App\Interfaces\CartServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Cart\CartRequest;

class CartController extends Controller
{
    protected $service;

    public function __construct(CartServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $carts = $this->service->index();

        return ApiResponseService::success($carts);
    }

    public function store(CartRequest $request): JsonResponse
    {
        $attrs = $request->validated();
        $attrs['user_id'] = $request->user()->getKey();
        $cart = $this->service->store($attrs);

        return ApiResponseService::success($cart);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return ApiResponseService::success();
    }
}
