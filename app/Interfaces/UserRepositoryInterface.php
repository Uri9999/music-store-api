<?php

namespace App\Interfaces;

use App\Models\User;
use Prettus\Repository\Contracts\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmailAndToken(string $email, string $token): ?User;
}
