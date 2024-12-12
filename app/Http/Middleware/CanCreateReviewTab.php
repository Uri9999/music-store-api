<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\ReviewTabRepositoryInterface;
use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanCreateReviewTab
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        $userId = $request->user()->getKey();
        /** @var OrderItemRepositoryInterface $orderItemRepository */
        $orderItemRepository = app(OrderItemRepositoryInterface::class);
        $orderItem = $orderItemRepository->whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', '!=', Order::STATUS_COMPLETED);
        })->where('tab_id', $id)->exists();
        if ($orderItem) {
            throw new CustomException('Đơn hàng chưa hoàn thành, không thể đánh giá.');
        }
        /** @var ReviewTabRepositoryInterface $reviewTabRepository */
        $reviewTabRepository = app(ReviewTabRepositoryInterface::class);
        $review = $reviewTabRepository->where('user_id', $userId)->where('tab_id', $id)->exists();
        if ($review) {
            throw new CustomException('Bạn đã đánh giá rồi.');
        }

        return $next($request);
    }
}

