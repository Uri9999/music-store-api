<?php

namespace App\Http\Controllers\Manage;

use App\Interfaces\RequestTabServiceInterface;
use App\Models\RequestTab;
use Illuminate\Http\JsonResponse;
use App\Services\ApiResponseService;
use App\Http\Requests\RequestTab\StoreTabRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestTabController extends Controller
{
    protected RequestTabServiceInterface $requestTabService;

    public function __construct(RequestTabServiceInterface $requestTabService)
    {
        $this->requestTabService = $requestTabService;
    }

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->requestTabService->index($request);

        return ApiResponseService::paginate($paginator);
    }

}
