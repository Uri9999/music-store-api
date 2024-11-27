<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Tab\TabRequest;
use Illuminate\Http\JsonResponse;
use App\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\TabServiceInterface;

class TabController extends Controller
{
    protected TabServiceInterface $service;

    public function __construct(TabServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }

    public function store(TabRequest $request): JsonResponse
    {
        $tab = $this->service->create($request);

        return ApiResponseService::success($tab, 'Create success', 201);
    }
}
