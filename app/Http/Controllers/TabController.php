<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tab\TabRequest;
use App\Interfaces\TabServiceInterface;
use App\Models\Tab;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class TabController extends Controller
{
    protected TabServiceInterface $tabService;

    public function __construct(TabServiceInterface $tabService)
    {
        $this->tabService = $tabService;
    }

    public function index(): JsonResponse
    {
        $tabs = $this->tabService->getAllTabs();

        return ApiResponseService::collection($tabs);
    }

    public function show($id): JsonResponse
    {
        $Tab = $this->tabService->getTabById($id);

        return ApiResponseService::success($Tab);
    }

    public function store(TabRequest $request): JsonResponse
    {
        $Tab = $this->tabService->createTab($request->validated());

        return ApiResponseService::success($Tab, 'Create success', 201);

    }

    public function update(TabRequest $request, Tab $tab): JsonResponse
    {
        $updatedTab = $this->tabService->updateTab($tab, $request->validated());

        return ApiResponseService::success($updatedTab);
    }

    public function destroy(Tab $tab): JsonResponse
    {
        return ApiResponseService::success($this->tabService->deleteTab($tab), 'Tab deleted successfully');
    }
}
