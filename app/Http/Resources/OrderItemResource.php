<?php

namespace App\Http\Resources;

use App\Models\Banner;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var OrderItem $orderItem */
        $orderItem = $this->resource;

        $array = [
            'id' => $orderItem->getKey(),
            'order_id' => $orderItem->order_id,
            'tab_id' => $orderItem->tab_id,
            'user_id' => $orderItem->user_id,
            'price' => $orderItem->price,
            'meta' => $orderItem->meta,
            'created_at' => $orderItem->created_at,
            'updated_at' => $orderItem->updated_at,
        ];
        if ($orderItem->relationLoaded('order')) {
            $array['order'] = new OrderResource($orderItem->order);
        }
        if ($orderItem->relationLoaded('user')) {
            $array['user'] = new UserResource($orderItem->user);
        }
        if ($orderItem->relationLoaded('tab')) {
            $array['tab'] = new TabResource($orderItem->tab);
        }

        return $array;
    }
}
