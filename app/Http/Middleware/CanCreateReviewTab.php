<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\ReviewTabRepositoryInterface;
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
        /** @var ReviewTabRepositoryInterface $reviewTabRepository */
        $reviewTabRepository = app(ReviewTabRepositoryInterface::class);
        $review = $reviewTabRepository->where('user_id', $userId)->where('tab_id', $id)->exists();
        if ($review) {
            throw new CustomException('Bạn đã đánh giá rồi.');
        }

        return $next($request);
    }
}

