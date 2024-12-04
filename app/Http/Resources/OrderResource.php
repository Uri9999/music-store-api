<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\User;
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
            'approval_date' => $order->approval_date,
            'approver_id' => $order->approver_id,
            'created_at' => $order->created_at->format('d/m/Y'),
        ];
        if ($order->relationLoaded('media')) {
            $array['media_bill'] = new MediaResource($order->getMedia(Order::MEDIA_BILL)->last());
        }

        if ($order->relationLoaded('user')) {
            $array['user']['id'] = $order->user->id;
            $array['user']['name'] = $order->user->name;
            $array['user']['avatar_url'] = new MediaResource($order->user->getMedia(User::MEDIA_AVATAR)->last());
        }

        if ($order->relationLoaded('approver') && $order->approver) {
            $array['approver']['id'] = $order->approver->id;
            $array['approver']['name'] = $order->approver->name;
        }

        if ($order->relationLoaded('orderItems')) {
            $array['order_items'] = $order->orderItems;
        }

        return $array;
    }
}
