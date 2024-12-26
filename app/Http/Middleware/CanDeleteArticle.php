<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Interfaces\ArticleRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanDeleteArticle
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
        if (!$article->isTypeArticle()) {
            throw new CustomException('Chỉ Admin mới có quyền thực hiện.');
        }
        if ($user->getKey() != $article->user_id) {
            throw new CustomException('Chỉ tác giả của bài viết mới có thể thực hiện.');
        }

        return $next($request);
    }
}
