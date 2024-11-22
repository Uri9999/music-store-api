<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\OrderRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsMyOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $orderId = $request->route('id');
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = app(OrderRepositoryInterface::class);
        $order = $orderRepository->find($orderId);
        if ($order->user_id != $request->user()->getKey()) {
            throw new CustomException('Bạn không thể xem thông tin đơn hàng của người khác.');
        }

        return $next($request);
    }
}
