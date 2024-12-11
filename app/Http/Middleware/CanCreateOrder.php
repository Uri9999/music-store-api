<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\OrderItemRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanCreateOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tabIds = $request->get('tab_ids');
        $userId = $request->user()->getKey();
        /** @var OrderItemRepositoryInterface $orderItemRepository */
        $orderItemRepository = app(OrderItemRepositoryInterface::class);
        $orderItems = $orderItemRepository->where('user_id', $userId)->whereIn('tab_id', $tabIds)->exists();
        if ($orderItems) {
            throw new CustomException('Không thể tạo đơn hàng.');
        }

        return $next($request);
    }
}
