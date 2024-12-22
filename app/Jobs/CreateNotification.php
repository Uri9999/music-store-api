<?php

namespace App\Jobs;

use App\Interfaces\NotificationServiceInterface;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

class CreateNotification implements ShouldQueue
{
    use Queueable;

    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        // $this->onQueue('notification');
    }

    public function handle(NotificationServiceInterface $repository)
    {
        $repository->store($this->data);
    }

    static public function createOrder(Order $order): void
    {
        self::dispatch([
            'type' => Notification::TYPE_CREATE_ORDER,
            'user_id' => $order->user_id,
            'title' => 'Thông báo đơn hàng tạo thành công',
            'body' => 'Bạn đã tạo đơn hàng thành công lúc: ' . $order->created_at->format('d-m-Y H:i:s') . ' . Chúng tôi sẽ phản hồi sớm nhất!',
        ]);
    }

    static public function approvalOrder(Order $order): void
    {
        self::dispatch([
            'type' => Notification::TYPE_APPROVE_ORDER,
            'user_id' => $order->user_id,
            'title' => 'Thông báo đơn hàng đã được phê duyệt',
            'body' => 'Đơn hàng đã phê duyệt thành công vào ngày ' . $order->approval_date->format('d-m-Y'),
        ]);
    }

    static public function cancelOrder(Order $order): void
    {
        self::dispatch([
            'type' => Notification::TYPE_CANCEL_ORDER,
            'user_id' => $order->user_id,
            'title' => 'Thông báo hủy đơn hàng',
            'body' => 'Đơn hàng của bạn đã bị hủy vào ngày ' . $order->updated_at->format('d-m-Y'),
        ]);
    }

    static public function registerSubscription(UserSubscription $sub): void
    {
        self::dispatch([
            'type' => Notification::TYPE_REGISTER_SUBSCRIPTION,
            'user_id' => $sub->user_id,
            'title' => 'Thông báo đăng ký subscription',
            'body' => 'Bạn đã đăng ký subscription thành công lúc: ' . $sub->created_at->format('d-m-Y H:i:s') . ' . Chúng tôi sẽ phản hồi sớm nhất!',
        ]);
    }

    static public function approveSubscription(UserSubscription $sub): void
    {
        self::dispatch([
            'type' => Notification::TYPE_APPROVE_SUBSCRIPTION,
            'user_id' => $sub->user_id,
            'title' => 'Thông báo subscription đã được phê duyệt',
            'body' => 'Subscription đã được phê duyệt thành công',
        ]);
    }

    static public function rejectSubscription(UserSubscription $sub): void
    {
        self::dispatch([
            'type' => Notification::TYPE_REJECT_ORDER,
            'user_id' => $sub->user_id,
            'title' => 'Thông báo hủy subscription',
            'body' => 'Subscription đã được hủy',
        ]);
    }
}
