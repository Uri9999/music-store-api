<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Article $article */
        $article = $this->resource;

        $array = [
            'id' => $article->getKey(),
            'slug' => $article->slug,
            'title' => $article->title,
            'content' => $article->content,
            'user_id' => $article->user_id,
            'status' => $article->status,
            'type' => $article->type,
        ];
        if ($article->relationLoaded('user')) {
            $user = $article->user;
            $array['user']['id'] = $user->getKey();
            $array['user']['name'] = $user->name;
            if ($user->relationLoaded('media')) {
                $array['user']['avatar'] = (new MediaResource($user->getMedia()->last()));
            }
        }

        return $array;
    }
}
