<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ApiResponseService;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            // Lấy tên role của người dùng hiện tại
            $userRole = Auth::user()->role->name;

            // Kiểm tra nếu role của user nằm trong danh sách được phép
            if (in_array($userRole, $roles)) {
                return $next($request);
            }
        }

        return ApiResponseService::error('Unauthorized', 403);
    }
}
