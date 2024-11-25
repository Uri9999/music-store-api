<?php

namespace App\Interfaces;

use App\Models\Category;
use Illuminate\Http\Request;

interface CategoryServiceInterface
{
    public function getAllCategories(Request $request);
    public function getCategoryById($id);
    public function createCategory(array $data);
    public function updateCategory(Category $category, array $data);
    public function deleteCategory(Category $category);
}
