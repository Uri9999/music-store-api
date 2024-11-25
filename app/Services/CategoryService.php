<?php

namespace App\Services;

use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(Request $request)
    {
        $query = $this->categoryRepository->with('parent:id,name');
        if ($name = $request->get('name')) {
            $query = $query->fullTextSearch($name);
        }
        $categories = $query->paginate(10);

        return $categories;
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(Category $category, array $data)
    {
        return $this->categoryRepository->update($data, $category->getKey());
    }

    public function deleteCategory(Category $category)
    {
        return $this->categoryRepository->delete($category->getKey());
    }
}
