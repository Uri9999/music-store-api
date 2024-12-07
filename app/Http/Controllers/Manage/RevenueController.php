<?php
namespace App\Http\Controllers\Manage;

use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Revenue\RevenueIndexRequest;
use App\Interfaces\RevenueServiceInterface;

class RevenueController extends Controller
{
    protected RevenueServiceInterface $service;

    public function __construct(RevenueServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(RevenueIndexRequest $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }
}

