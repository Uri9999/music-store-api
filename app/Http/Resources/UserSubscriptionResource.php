<?php

namespace App\Http\Resources;

use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var UserSubscription $userSubscription */
        $userSubscription = $this->resource;
        $array = $this->resource->toArray();

        if ($userSubscription->relationLoaded('media')) {
            $array['bill'] = new MediaResource($userSubscription->getMedia(UserSubscription::MEDIA_SUBSCRIPTION_BILL)->last());
        }

        return $array;
    }
}
