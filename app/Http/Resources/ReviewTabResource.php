<?php

namespace App\Http\Resources;

use App\Models\ReviewTab;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewTabResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ReviewTab $reviewTab */
        $reviewTab = $this->resource;

        $array = [
            'id' => $reviewTab->getKey(),
            'user_id' => $reviewTab->user_id,
            'tab_id' => $reviewTab->tab_id,
            'rating' => $reviewTab->rating,
            'comment' => $reviewTab->comment,
            'status' => $reviewTab->status,
            'created_at' => $reviewTab->created_at,
            'updated_at' => $reviewTab->updated_at,
        ];

        if ($reviewTab->relationLoaded('user')) {
            $array['user'] = new UserResource($reviewTab->user);
        }
        if ($reviewTab->relationLoaded('tab')) {
            $array['tab'] = new TabResource($reviewTab->tab);
        }

        return $array;
    }
}
