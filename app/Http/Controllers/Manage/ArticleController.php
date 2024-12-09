<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\ArticleStoreRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;
use App\Interfaces\ArticleServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $service;

    public function __construct(ArticleServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }

    public function store(ArticleStoreRequest $request): JsonResponse
    {
        $attrs = $request->validated();
        $attrs['user_id'] = $request->user()->getKey();
        $article = $this->service->store($attrs);

        return ApiResponseService::success($article, 'Tạo thành công.');
    }

    public function update(ArticleUpdateRequest $request, int $id): JsonResponse
    {
        $attrs = $request->validated();
        $article = $this->service->update($id, $attrs);

        return ApiResponseService::success($article, 'Cập nhật thành công.');
    }

    public function show(int $id): JsonResponse
    {
        $article = $this->service->show($id);

        return ApiResponseService::success($article);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return ApiResponseService::success(null, 'Xóa thành công.');
    }

    public function getPolicy(): JsonResponse
    {
        return ApiResponseService::success($this->service->getPolicy());
    }

    public function getTutorial(): JsonResponse
    {
        return ApiResponseService::success($this->service->getTutorial());
    }
}
