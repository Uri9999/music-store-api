<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            'access_token' => $resource['access_token'],
            'expires_at' => $resource['expires_at'],
        ];
        $user = $resource['user'];
        if ($user) {
            $array['user']['id'] = $user->id;
            $array['user']['name'] = $user->name;
            $array['user']['status'] = $user->status;
            $array['user']['email'] = $user->email;
            $array['user']['dob'] = $user->dob;
            $array['user']['gender'] = $user->gender;
            $array['user']['role_id'] = $user->role_id;
        }
        if ($user->relationLoaded('media')) {
            $array['user']['avatar'] = new MediaResource($user->getMedia(User::MEDIA_AVATAR)->last());
        }

        return $array;
    }
}
