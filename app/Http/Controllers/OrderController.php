<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Order\StoreRequest;
use App\Services\ApiResponseService;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request)
    {
        $this->service->store($request);

        return ApiResponseService::success(null, 'Tạo order thành công');
    }

}
