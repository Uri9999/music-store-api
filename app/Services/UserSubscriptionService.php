<?php

namespace App\Services;

use App\Interfaces\SubscriptionRepositoryInterface;
use App\Interfaces\UserSubscriptionRepositoryInterface;
use App\Interfaces\UserSubscriptionServiceInterface;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserSubscriptionService implements UserSubscriptionServiceInterface
{
    protected UserSubscriptionRepositoryInterface $repository;

    public function __construct(UserSubscriptionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function register(Request $request): UserSubscription
    {
        $userId = $request->user()->getKey();
        $subscriptionId = $request->get('subscription_id');
        $lastestSub = $this->repository->where('user_id', $userId)->max('end_date');
        $startDate = Carbon::today();
        if ($lastestSub && Carbon::parse($lastestSub) > Carbon::today()) {
            $startDate = Carbon::parse($lastestSub)->addDay();
        }

        /** @var SubscriptionRepositoryInterface $subscriptionRepository */
        $subscriptionRepository = app(SubscriptionRepositoryInterface::class);
        $subscription = $subscriptionRepository->find($subscriptionId);

        $userSubscription = $this->repository->create([
            'subscription_id' => $subscriptionId,
            'user_id' => $userId,
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->addDays($subscription->duration_in_days),
            'meta' => [
                'price' => $subscription->price
            ]
        ]);

        return $userSubscription;
    }
}
