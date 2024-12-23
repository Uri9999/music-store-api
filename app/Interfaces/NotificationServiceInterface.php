<?php

namespace App\Interfaces;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationServiceInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function show(int $id, int $userId): ?Notification;
    public function store(array $attrs): Notification;
    public function updateToSent(Notification $notification);
    public function countNotReadYet(Request $request): int;
    public function getMyNotify(Request $request): LengthAwarePaginator;
    public function readAll(Request $request): void;
}
