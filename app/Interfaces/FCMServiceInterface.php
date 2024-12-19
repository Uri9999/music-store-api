<?php

namespace App\Interfaces;

use Kreait\Firebase\Messaging\Notification;

interface FCMServiceInterface
{
    public function send(
        string $targetType,
        string $targetValue,
        Notification $notification = null,
        array $data = [],
        int $badge = null
    ): void;

    public function sendToDevice(string $deviceToken, Notification $notification = null, $data = [], $badge = null): void;
    public function createNotice(string $title, string $body, ?string $imgUrl = null): Notification;
}
