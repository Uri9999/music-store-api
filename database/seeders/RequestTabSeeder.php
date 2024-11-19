<?php

namespace Database\Seeders;

use App\Models\RequestTab;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', 3)->get();

        foreach (range(1, 10) as $index) {
            RequestTab::create([
                'user_id' => $users->random()->id,
                'name' => 'Request ' . $index,
                'author' => 'nhat ',
                'status' => rand(0, 1),
                'receiver_id' => $users->random()->id,
            ]);
        }
    }
}
