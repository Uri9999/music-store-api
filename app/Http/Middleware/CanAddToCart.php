<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanAddToCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tabId = $request->get('tab_id');
        $userId = $request->user()->getKey();
        /** @var CartRepositoryInterface $cartRepository */
        $cartRepository = app(CartRepositoryInterface::class);
        $cart = $cartRepository->where('user_id', $userId)->where('tab_id', $tabId)->exists();

        /** @var OrderItemRepositoryInterface $orderItemRepository */
        $orderItemRepository = app(OrderItemRepositoryInterface::class);
        $orderItem = $orderItemRepository->where('tab_id', $tabId)
            ->whereHas('order', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->exists();

        if ($cart || $orderItem) {
            throw new CustomException('Sản phẩm đã tồn tại trong giỏ hàng hoặc đang trong quá trình phê duyệt.');
        }

        return $next($request);
    }
}
