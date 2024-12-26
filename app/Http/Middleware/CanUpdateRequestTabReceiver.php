<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\RequestTabRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanUpdateRequestTabReceiver
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->get('receiver_id');
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);
        $user = $userRepository->find($userId);
        if ($user->isUser()) {
            throw new CustomException('Chỉ có thể cập nhật cho người dùng là Affiliate, Admin, Staff.');
        }
        if (!$user->isStatusActive()) {
            throw new CustomException('Trạng thái người dùng chưa Active.');
        }

        return $next($request);
    }
}
