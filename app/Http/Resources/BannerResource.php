<?php

namespace App\Http\Resources;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Banner $banner */
        $banner = $this->resource;

        $array = [
            'id' => $banner->getKey(),
            'name' => $banner->name,
            'description' => $banner->description,
        ];
        if ($banner->relationLoaded('media')) {
            $array['images_url'] = MediaResource::collection($banner->getMedia(Banner::MEDIA_BANNER));
        }

        return $array;
    }
}
