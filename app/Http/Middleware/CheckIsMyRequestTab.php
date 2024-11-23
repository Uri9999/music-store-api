<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\RequestTabRepositoryInterface;
use App\Models\RequestTab;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsMyRequestTab
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        /** @var RequestTabRepositoryInterface $requestTabRepository */
        $requestTabRepository = app(RequestTabRepositoryInterface::class);
        $requestTab = $requestTabRepository->find($id);
        if ($requestTab->user_id != $request->user()->getKey()) {
            throw new CustomException('Bạn không thể thao tác trên yêu cầu tab của người khác.');
        }
        if ($requestTab->status !== RequestTab::STATUS_DEFAULT) {
            throw new CustomException('Yêu cầu tab đang được thực hiện, không thể thao tác.');
        }

        return $next($request);
    }
}
