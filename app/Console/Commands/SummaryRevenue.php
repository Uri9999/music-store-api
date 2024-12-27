<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRevenueEmail;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Carbon;

class SummaryRevenue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:summary-revenue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->subMonth()->toDateString();
        $month = Carbon::now()->format('m');
        User::query()->whereIn('role_id', [Role::ROLE_STAFF, Role::ROLE_AFFILIATE, Role::ROLE_ADMIN])->where('id', 11)
            ->with([
                'role:id,name',
            ])
            ->withSum([
                'orderItems' => function ($q) use ($startDate, $endDate) {
                    $q->whereHas('order', function ($subQuery) use ($startDate, $endDate) {
                        $subQuery->where('status', Order::STATUS_COMPLETED)
                            ->when($startDate, function ($query, string $startDate) {
                                $query->where('approval_date', '>=', $startDate);
                            })
                            ->when($endDate, function ($query, string $endDate) {
                                $query->where('approval_date', '<=', $endDate);
                            });
                    });
                }
            ], 'price')
            ->withSum([
                'referralCommissions' => function ($q) use ($startDate, $endDate) {
                    $q->where('status', UserSubscription::STATUS_APPROVED)
                        ->when($startDate, function ($query, string $startDate) {
                            $query->where('approval_date', '>=', $startDate);
                        })
                        ->when($endDate, function ($query, string $endDate) {
                            $query->where('approval_date', '<=', $endDate);
                        });
                }
            ], 'price')->chunkById(50, function ($users) use ($month) {
                /** @var User $user */
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new UserRevenueEmail($user->name, $month, $user->commission_rate, $user->order_items_sum_price, $user->referral_commissions_sum_price));
                }
            });
    }
}
