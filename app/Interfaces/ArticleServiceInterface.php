<?php

namespace App\Interfaces;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ArticleServiceInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function store(array $attrs): Article;
    public function update(int $id, array $attrs): Article;
    public function show(int $id): Article;
    public function delete(int $id): void;
    public function getPolicy(): ?Article;
    public function getTutorial(): ?Article;
    public function getArticle(Request $request): LengthAwarePaginator;
}
