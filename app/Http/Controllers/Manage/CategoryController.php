<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Interfaces\CategoryServiceInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return ApiResponseService::paginate($this->categoryService->getAllCategories());
    }

    public function show($id)
    {
        return ApiResponseService::success($this->categoryService->getCategoryById($id));
    }

    public function store(CategoryRequest $request)
    {
        return ApiResponseService::success($this->categoryService->createCategory($request->validated()), 'Create success', 201);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        return ApiResponseService::success($this->categoryService->updateCategory($category, $request->validated()));
    }

    public function destroy(Category $category)
    {
        return ApiResponseService::success($this->categoryService->deleteCategory($category), 'Category deleted successfully');
    }
}
