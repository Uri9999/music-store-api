<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\UserRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanLockUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);
        $user = $userRepository->find($id);
        if ($user->isAdmin()) {
            throw new CustomException('Không thể khóa tài khoản của admin');
        }

        return $next($request);
    }
}
