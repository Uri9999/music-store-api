<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function lock($id): void;
    public function unlock($id): void;
    public function show(int $id): ?User;
    public function update(int $id, Request $request): void;
}
