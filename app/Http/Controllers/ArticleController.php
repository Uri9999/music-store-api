<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Interfaces\ArticleServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected ArticleServiceInterface $service;

    public function __construct(ArticleServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getArticle(Request $request): JsonResponse
    {
        $paginator = $this->service->getArticle($request);

        return ApiResponseService::paginate($paginator, 'success', 200, ArticleResource::class);
    }

    public function getDetailArticle(string $slug): JsonResponse
    {
        $article = $this->service->getDetailArticle($slug);
        $resource = new ArticleResource($article);

        return ApiResponseService::success($resource);
    }

    public function getRandomArticle(): JsonResponse
    {
        $articles = $this->service->getRandomArticle();
        $resource = ArticleResource::collection($articles);

        return ApiResponseService::success($resource);
    }
}
