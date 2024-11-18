<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Tạo danh mục cha
        $parentCategory = Category::create([
            'name' => 'Electronics',
            'description' => 'All electronic items',
        ]);
        $parentCategory2 = Category::create([
            'name' => 'Yellow',
            'description' => 'All electronic items',
        ]);
        $parentCategory3 = Category::create([
            'name' => 'Green',
            'description' => 'All electronic items',
        ]);

        // Tạo các danh mục con
        Category::create([
            'name' => 'Mobile Phones',
            'description' => 'All kinds of mobile phones',
            'parent_id' => $parentCategory->id,
        ]);
        Category::create([
            'name' => 'Laptops',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory->id,
        ]);
        Category::create(attributes: [
            'name' => 'sky',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory->id,
        ]);
        Category::create([
            'name' => 'one start',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory->id,
        ]);

        Category::create([
            'name' => 'Mobile Phones',
            'description' => 'All kinds of mobile phones',
            'parent_id' => $parentCategory2->id,
        ]);
        Category::create([
            'name' => 'Laptops',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory2->id,
        ]);
        Category::create(attributes: [
            'name' => 'sky',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory2->id,
        ]);
        Category::create([
            'name' => 'one start',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory2->id,
        ]);

        Category::create([
            'name' => 'Mobile Phones',
            'description' => 'All kinds of mobile phones',
            'parent_id' => $parentCategory3->id,
        ]);
        Category::create([
            'name' => 'Laptops',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory3->id,
        ]);
        Category::create(attributes: [
            'name' => 'sky',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory3->id,
        ]);
        Category::create([
            'name' => 'one start',
            'description' => 'All kinds of laptops',
            'parent_id' => $parentCategory3->id,
        ]);
    }
}
