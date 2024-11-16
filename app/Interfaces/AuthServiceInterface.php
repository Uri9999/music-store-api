<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data);
    public function login(array $data);
    public function logout();
    public function forgotPassword(User $user);
    public function resetPassword(User $user, string $token);
}
