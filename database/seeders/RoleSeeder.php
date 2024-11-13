<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Affiliate', 'User'];
        foreach ($roles as $roleName) {
            // Kiểm tra và tạo role nếu chưa tồn tại
            Role::firstOrCreate(
                ['name' => $roleName], // Điều kiện kiểm tra
                ['name' => $roleName]  // Dữ liệu để tạo nếu chưa tồn tại
            );
        }
    }
}
