<?php

namespace App\Interfaces;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function update(Category $category, array $data);
    public function delete(Category $category);
}
