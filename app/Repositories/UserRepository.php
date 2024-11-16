<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model(): string
    {
        return User::class;
    }
}
