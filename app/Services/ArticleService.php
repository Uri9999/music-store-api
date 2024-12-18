<?php

namespace App\Services;

use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\ArticleServiceInterface;
use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ArticleService implements ArticleServiceInterface
{
    protected $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->repository->with('user:id,name');
        if ($search = $request->get('search')) {
            $query = $query->fullTextSearch($search);
        }
        $articles = $query->paginate(10);

        return $articles;
    }

    public function getArticle(Request $request): LengthAwarePaginator
    {
        $query = $this->repository->with([
            'user:id,name',
            'user.media' => function ($query) {
                $query->whereIn('collection_name', [User::MEDIA_AVATAR]);
            }
        ]);
        if ($search = $request->get('search')) {
            $query = $query->fullTextSearch($search);
        }
        $articles = $query->where('type', Article::TYPE_ARTICLE)->where('status', Article::STATUS_PUBLIC)->paginate(10);

        return $articles;
    }

    public function store(array $attrs): Article
    {
        $article = $this->repository->create($attrs);

        return $article;
    }

    public function update(int $id, array $attrs): Article
    {
        $article = $this->repository->update($attrs, $id);

        return $article;
    }

    public function show(int $id): Article
    {
        $article = $this->repository->find($id)->load([
            'user:id,name',
            'user.media' => function ($query) {
                $query->whereIn('collection_name', [User::MEDIA_AVATAR]);
            },
        ]);

        return $article;
    }

    public function getDetailArticle(int $id): ?Article
    {
        $query = $this->repository->with([
            'user:id,name',
            'user.media' => function ($query) {
                $query->whereIn('collection_name', [User::MEDIA_AVATAR]);
            }
        ]);
        $article = $query->where('type', Article::TYPE_ARTICLE)->where('status', Article::STATUS_PUBLIC)->find($id);

        return $article;
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function getPolicy(): ?Article
    {
        $article = $this->repository->where('type', Article::TYPE_POLICY)->first();

        return $article;
    }

    public function getTutorial(): ?Article
    {
        $article = $this->repository->where('type', Article::TYPE_TUTORIAL)->first();

        return $article;
    }

    public function getRandomArticle(): Collection
    {
        $query = $this->repository->with([
            'user:id,name',
            'user.media' => function ($query) {
                $query->whereIn('collection_name', [User::MEDIA_AVATAR]);
            }
        ]);
        $articles = $query->where('type', Article::TYPE_ARTICLE)->where('status', Article::STATUS_PUBLIC)->inRandomOrder()->take(10)->get();

        return $articles;
    }
}
