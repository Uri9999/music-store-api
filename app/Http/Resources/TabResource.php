<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tab;
use Illuminate\Http\Resources\Json\JsonResource;

class TabResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Tab $tab */
        $tab = $this->resource;

        $array = [
            'id' => $tab->getKey(),
            'name' => $tab->name,
            'description' => $tab->description,
            'user' => $tab?->user,
            'author' => $tab->author,
            'price' => $tab->price,
            'category' => $tab?->category,
            'youtube_url' => $tab->youtube_url,
            'user_id' => $tab->user_id,
            'category_id' => $tab->category_id,

        ];
        if ($tab->relationLoaded('media')) {
            $array['images_url'] = MediaResource::collection($tab->getMedia(Tab::MEDIA_TAB_IMAGE));
            $array['pdf'] = new MediaResource($tab->getMedia(Tab::MEDIA_TAB_PDF)->last());
        }

        return $array;
    }
}
