<?php

namespace App\Interfaces;

interface AuthServiceInterface
{
    public function register(array $data);
    public function login(array $data);
    public function logout();
}
