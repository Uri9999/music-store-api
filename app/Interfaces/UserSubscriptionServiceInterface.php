<?php

namespace App\Interfaces;

use App\Models\UserSubscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserSubscriptionServiceInterface
{
    public function register(Request $request): UserSubscription;
}
