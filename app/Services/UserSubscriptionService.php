<?php

namespace App\Services;

use App\Interfaces\SubscriptionRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserSubscriptionRepositoryInterface;
use App\Interfaces\UserSubscriptionServiceInterface;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserSubscriptionService implements UserSubscriptionServiceInterface
{
    protected UserSubscriptionRepositoryInterface $repository;

    public function __construct(UserSubscriptionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function register(Request $request): UserSubscription
    {
        $introducerId = null;
        if ($referralCode = $request->get('referral_code')) {
            /** @var UserRepositoryInterface $userRepository */
            $userRepository = app(UserRepositoryInterface::class);
            $introducer = $userRepository->where('referral_code', $referralCode)->first();
            $introducerId = $introducer->getKey();
        }
        $userId = $request->user()->getKey();
        $subscriptionId = $request->get('subscription_id');
        $lastestSub = $this->repository->where('user_id', $userId)->where('status', UserSubscription::STATUS_APPROVED)->max('end_date');
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
            ],
            'note' => $request->get('note'),
            'price' => $subscription->price,
            'introducer_id' => $introducerId,
        ]);
        if ($request->file('bill')) {
            $userSubscription->addMediaFromRequest('bill')->toMediaCollection(UserSubscription::MEDIA_SUBSCRIPTION_BILL);
        }

        return $userSubscription;
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->repository->with([
            'user:id,name',
            'approver:id,name',
            'rejector:id,name',
            'subscription:id,name',
            'media' => function ($query) {
                $query->whereIn('collection_name', [UserSubscription::MEDIA_SUBSCRIPTION_BILL]);
            }
        ]);

        if ($status = $request->get('status')) {
            $query = $query->whereIn('status', $status);
        }

        if ($search = $request->get('search')) {
            $query = $query->whereHas('user', function (Builder $q) use ($search) {
                $q->fullTextSearch($search);
            });
        }

        $items = $query->orderBy('created_at', 'DESC')->paginate(10);

        return $items;
    }

    public function approve(int $id, int $approverId): void
    {
        $this->repository->update([
            'status' => UserSubscription::STATUS_APPROVED,
            'approver_id' => $approverId,
            'approval_date' => Carbon::today(),
        ], $id);
    }

    public function reject(int $id, int $rejectorId): void
    {
        $this->repository->update([
            'status' => UserSubscription::STATUS_REJECTED,
            'rejector_id' => $rejectorId,
        ], $id);
    }
}
