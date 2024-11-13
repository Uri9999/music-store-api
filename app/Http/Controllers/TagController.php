<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagRequest;
use App\Interfaces\TagServiceInterface;
use App\Models\Tag;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    protected TagServiceInterface $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(): JsonResponse
    {
        $tags = $this->tagService->getAllTags();

        return ApiResponseService::collection($tags);
    }

    public function show($id): JsonResponse
    {
        $tag = $this->tagService->getTagById($id);

        return ApiResponseService::success($tag);
    }

    public function store(TagRequest $request): JsonResponse
    {
        $tag = $this->tagService->createTag($request->validated());

        return ApiResponseService::success($tag, 'Create success', 201);

    }

    public function update(TagRequest $request, Tag $tag): JsonResponse
    {
        $updatedTag = $this->tagService->updateTag($tag, $request->validated());

        return ApiResponseService::success($updatedTag);
    }

    public function destroy(Tag $tag): JsonResponse
    {
        return ApiResponseService::success($this->tagService->deleteTag($tag), 'Tag deleted successfully');
    }
}
