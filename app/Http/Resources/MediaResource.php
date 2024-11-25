<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Media $resource */
        $resource = $this->resource;

        $url = $this->getPath($resource);

        return [
            'id' => $resource->getKey(),
            'url' => $url,
        ];
    }

    protected function getPath(Media $media): string
    {
        try {
            $url = $media->getTemporaryUrl(Carbon::now()->addMinutes(60));
        } catch (Exception $exception) {
            $url = $media->getFullUrl();
        }

        return $url;
    }
}
