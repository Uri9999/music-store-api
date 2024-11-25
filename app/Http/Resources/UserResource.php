<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;

        $array = [
            'id' => $user->getKey(),
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'role_id' => $user->role_id,
            'gender' => $user->gender,
            'dob' => $user->dob,
        ];
        if ($user->relationLoaded('media')) {
            $array['avatar'] = new MediaResource($user->getMedia(User::MEDIA_AVATAR)->last());
        }

        return $array;
    }
}
