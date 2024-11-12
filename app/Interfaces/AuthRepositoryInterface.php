<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function createUser(array $data);
    public function getUserByEmail(string $email);
}
