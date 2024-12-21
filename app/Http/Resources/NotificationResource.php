<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = $this->resource;

        $array = [
            'id' => $resource->getKey(),
            'title' => $resource->title,
            'body' => $resource->body,
            'type' => $resource->type,
            'user_id' => $resource->user_id,
            'status' => $resource->status,
            'send_at' => $resource->send_at,
            'meta' => $resource->meta,
        ];
       
        return $array;
    }
}
