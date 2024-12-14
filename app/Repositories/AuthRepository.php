<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function getUserByEmail(string $email)
    {
        return User::with([
            'media' => function ($q) {
                $q->where('collection_name', User::MEDIA_AVATAR);
            }
        ])->where('email', $email)->first();
    }
}
