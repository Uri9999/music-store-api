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
                'feature' => [
                    'Xem tải toàn bộ bài tab',
                    'Tham gia Group Tự Học Kalimba',
                    'Hỗ trợ qua kênh chat Zalo',
                ],
            ]
        );

        Subscription::updateOrCreate(
            ['name' => '3 tháng'],
            [
                'duration_in_days' => 90,
                'price' => 30000,
                'feature' => [
                    'Bao gồm các quyền lợi gói 1 tháng',
                    'Giảm giá 10% khi sử dụng dịch vụ làm tab theo yêu cầu',
                    'Hỗ trợ Call Video giải đáp đoạn Tab',
                    'Tặng voucher giảm giá 12% khi mua hàng tại Zumi Shop',
                ],
            ]
        );

        Subscription::updateOrCreate(
            ['name' => '6 tháng'],
            [
                'duration_in_days' => 180,
                'price' => 50000,
                'feature' => [
                    'Bao gồm các quyền lợi gói 6 tháng',
                    'Giảm giá 15% khi sử dụng dịch vụ làm tab theo yêu cầu',
                    'Tham gia lớp học đàn Kalimba Online miễn phí',
                    'Tặng voucher giảm giá 15% khi mua hàng tại Zumi Shop',
                ],
            ],
        );
    }
}
