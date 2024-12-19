<?php

namespace App\Services;

use App\Interfaces\FCMServiceInterface;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMService implements FCMServiceInterface
{
    private Messaging $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function send(
        string $targetType,
        string $targetValue,
        Notification $notification = null,
        array $data = [],
        int $badge = null
    ): void {
        // Tạo CloudMessage với mục tiêu (target) được chỉ định
        $message = CloudMessage::withTarget($targetType, $targetValue);

        // Nếu có notification, thêm vào message
        if ($notification) {
            $message = $message->withNotification($notification);
        }

        // Nếu có dữ liệu (data), thêm vào message
        if (!empty($data)) {
            $message = $message->withData($data);
        }

        // Cấu hình APNs cho iOS
        $apnsConfig = ApnsConfig::fromArray([
            'headers' => [
                'apns-priority' => '10', // Ưu tiên cao cho thông báo ngay lập tức
            ],
            'payload' => [
                'aps' => [
                    'alert' => $notification ? $notification->jsonSerialize() : [],
                    'data' => $data,
                ],
            ],
        ])->withDefaultSound(); // Thêm âm thanh mặc định cho iOS

        // Nếu có badge, thêm vào cấu hình APNs
        if (!is_null($badge)) {
            $apnsConfig = $apnsConfig->withBadge($badge);
        }

        // Thêm cấu hình APNs và âm thanh vào message
        $message = $message->withApnsConfig($apnsConfig);
        // dd($message);

        // Gửi thông báo qua Firebase Messaging
        $this->messaging->send($message);
    }

    /**
     * @throws \Kreait\Firebase\Exception\MessagingException
     * @throws \Kreait\Firebase\Exception\FirebaseException
     */
    public function sendToDevice(string $deviceToken, Notification $notification = null, $data = [], $badge = null): void
    {
        $this->send('token', $deviceToken, $notification, $data, $badge);
    }

    public function createNotice(string $title, string $body, ?string $imgUrl = null): Notification
    {
        $notice = Notification::create($title, $body, $imgUrl);

        return $notice;
    }
}
