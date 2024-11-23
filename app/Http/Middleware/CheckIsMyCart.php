<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\CartRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsMyCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        /** @var CartRepositoryInterface $cartRepository */
        $cartRepository = app(CartRepositoryInterface::class);
        $cart = $cartRepository->find($id);
        if ($cart->user_id != $request->user()->getKey()) {
            throw new CustomException('Bạn không thể xóa giỏ hàng của người khác.');
        }

        return $next($request);
    }
}
