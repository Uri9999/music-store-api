<?php
namespace App\Http\Controllers\Manage;

use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\RevenueServiceInterface;

class RevenueController extends Controller
{
    protected RevenueServiceInterface $service;

    public function __construct(RevenueServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(UserIndexRequest $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }
}

