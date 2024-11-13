<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tab;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả user và category hiện có để liên kết
        $users = User::all();
        $categories = Category::all();

        // Tạo 20 tab mẫu
        foreach (range(1, 100) as $index) {
            Tab::create([
                'name' => 'Tab ' . $index,
                'description' => 'Description for Tab ' . $index,
                'user_id' => $users->random()->id, // Chọn ngẫu nhiên một user
                'author' => 'Author ' . $index,
                'price' => rand(10, 100), // Giá ngẫu nhiên từ 10 đến 100
                'category_id' => $categories->random()->id, // Chọn ngẫu nhiên một category
            ]);
        }
    }
}
