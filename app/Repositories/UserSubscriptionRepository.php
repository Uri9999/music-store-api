<?php

namespace App\Repositories;

use App\Interfaces\UserSubscriptionRepositoryInterface;
use App\Models\UserSubscription;
use Prettus\Repository\Eloquent\BaseRepository;

class UserSubscriptionRepository extends BaseRepository implements UserSubscriptionRepositoryInterface
{
    public function model(): string
    {
        return UserSubscription::class;
    }

}
