<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\UserSubscriptionRepositoryInterface;
use App\Models\UserSubscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanRegisterSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        /** @var UserSubscriptionRepositoryInterface $userSubscriptionRepository */
        $userSubscriptionRepository = app(UserSubscriptionRepositoryInterface::class);
        $sub = $userSubscriptionRepository->where('user_id', $request->user()->getKey())->where('status', UserSubscription::STATUS_PENDING)->first();

        if ($sub) {
            throw new CustomException('Subscription trước đó đang ở trạng thái chờ duyệt, không thể gửi yêu cầu đăng ký thêm.');
        }

        return $next($request);
    }
}
