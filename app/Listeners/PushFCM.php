<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use App\Interfaces\DeviceTokenServiceInterface;
use App\Interfaces\FCMServiceInterface;
use App\Interfaces\NotificationServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Messaging\NotFound;

class PushFCM
{
    private FCMServiceInterface $fCMService;
    private DeviceTokenServiceInterface $deviceTokenService;
    private NotificationServiceInterface $notificationService;

    public function __construct(FCMServiceInterface $fCMService, DeviceTokenServiceInterface $deviceTokenService, NotificationServiceInterface $notificationService)
    {
        $this->fCMService = $fCMService;
        $this->deviceTokenService = $deviceTokenService;
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationCreated $event): void
    {
        $notification = $event->getNotification();
        $deviceToken = $this->deviceTokenService->getByUserId($notification->user_id);
        if (!$deviceToken) {
            return;
        }
        // if ($notification->status == 1) {
        //     return;
        // }
        Log::info('get');
        $token = $deviceToken->token;
        $notice = $this->fCMService->createNotice($notification->title, $notification->body);

        try {
            $this->fCMService->sendToDevice($token, $notice);
            $this->notificationService->updateToSent($notification);
        } catch (NotFound $exception) {
            Log::info($exception->getMessage());
        }
    }
}
