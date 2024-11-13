<?php

namespace App\Interfaces;

use App\Models\Category;

interface CategoryServiceInterface
{
    public function getAllCategories();
    public function getCategoryById($id);
    public function createCategory(array $data);
    public function updateCategory(Category $category, array $data);
    public function deleteCategory(Category $category);
}
