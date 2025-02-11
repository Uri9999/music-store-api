<?php

namespace App\Http\Resources;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TabResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Cart $cart */
        $cart = $this->resource;

        $array = [
            'id' => $cart->getKey(),
            'user_id' => $cart->user_id,
            'tab_id' => $cart->tab_id,
        ];

        if ($cart->relationLoaded('tab')) {
            $array['tab'] = new TabResource($cart->tab);
        }
        if ($cart->relationLoaded('user')) {
            $array['user'] = new UserResource($cart->user);
        }

        return $array;
    }
}
