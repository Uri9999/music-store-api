<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subscription::updateOrCreate(
            ['name' => '1 tháng'],
            [

                'duration_in_days' => 30,
                'price' => 20000,
            ]
        );

        Subscription::updateOrCreate(
            ['name' => '3 tháng'],
            [
                'duration_in_days' => 90,
                'price' => 30000,
            ]
        );

        Subscription::updateOrCreate(
            ['name' => '6 tháng'],
            [
                'duration_in_days' => 180,
                'price' => 50000,
            ]
        );
    }
}
