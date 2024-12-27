<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\TabRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanUpdateTab
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        /** @var TabRepositoryInterface $tabRepository */
        $tabRepository = app(TabRepositoryInterface::class);
        $tab = $tabRepository->find($id);
        $user = $request->user();

        if ($user->isAffiliate() && $user->getKey() != $tab->user_id) {
            throw new CustomException('Không có quyền thực hiện.', 403);
        }

        return $next($request);
    }
}
