<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo một tài khoản admin
        User::factory()->admin()->create();

        // Tạo 10 người dùng ngẫu nhiên
        User::factory()->count(10)->create();

    }
}
