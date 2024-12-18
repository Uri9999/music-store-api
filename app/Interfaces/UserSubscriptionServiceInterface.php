<?php

namespace App\Interfaces;

use App\Models\UserSubscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface UserSubscriptionServiceInterface
{
    public function register(Request $request): UserSubscription;
    public function index(Request $request): LengthAwarePaginator;
    public function approve(int $id, int $approverId): void;
    public function reject(int $id, int $rejectorId): void;
    public function getMyUserSubscription(int $userId): LengthAwarePaginator;
    public function checkSubscriptionValid(int $userId): bool;
}
