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
        $discountMoney = $tab->discount_money ?? 0;
        $priceDiscount = max(0, $tab->price - $discountMoney);
        $array = [
            'id' => $tab->getKey(),
            'slug' => $tab->slug,
            'name' => $tab->name,
            'description' => $tab->description,
            'user' => $tab?->user,
            'author' => $tab->author,
            'price' => $tab->price,
            'category' => $tab?->category,
            'youtube_url' => $tab->youtube_url,
            'user_id' => $tab->user_id,
            'category_id' => $tab->category_id,
            'total_order_items' => $tab->total_order_items ?? 0,
            'discount_money' => $discountMoney,
            'price_discount' => $priceDiscount,

        ];
        if ($tab->relationLoaded('media')) {
            $array['images_url'] = MediaResource::collection($tab->getMedia(Tab::MEDIA_TAB_IMAGE));
            $array['pdf'] = new MediaResource($tab->getMedia(Tab::MEDIA_TAB_PDF)->last());
        }
        if ($tab->relationLoaded('reviewTabs')) {
            $array['reviewTabs'] = ReviewTabResource::collection($tab->reviewTabs);
            $array['reviewTabsAvg'] = round($tab->reviewTabs()->avg('rating'), 1);
            $array['reviewTabsCount'] = $tab->reviewTabs()->count();
        }
        if ($tab->relationLoaded('user')) {
            $array['user'] = new UserResource($tab->user);
        }

        return $array;
    }
}
