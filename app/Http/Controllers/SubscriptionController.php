<?php

namespace App\Http\Controllers;

use App\Interfaces\SubscriptionServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    protected SubscriptionServiceInterface $service;

    public function __construct(SubscriptionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $subscriptions = $this->service->index();

        return ApiResponseService::collection($subscriptions);
    }
}
