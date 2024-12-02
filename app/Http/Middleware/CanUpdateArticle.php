<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\ArticleRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanUpdateArticle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        /** @var ArticleRepositoryInterface $articleRepository */
        $articleRepository = app(ArticleRepositoryInterface::class);
        $article = $articleRepository->find($id);
        $user = $request->user();
        if (!$article->isTypeArticle() && !$user->isAdmin()) {
            throw new CustomException('Chỉ Admin mới có quyền thực hiện.');
        }

        return $next($request);
    }
}
