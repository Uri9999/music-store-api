<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Order $order */
        $order = $this->resource;

        $array = [
            'id' => $order->getKey(),
            'user_id' => $order->user_id,
            'status' => $order->status,
            'type' => $order->type,
            'total_price' => $order->total_price,
            'note' => $order->note,
        ];
        if ($order->relationLoaded('media')) {
            $array['media_bill'] = new MediaResource($order->getMedia(Order::MEDIA_BILL)->last());
        }

        if ($order->relationLoaded('user')) {
            $array['user']['id'] = $order->user->id;
            $array['user']['name'] = $order->user->name;
        }

        return $array;
    }
}
