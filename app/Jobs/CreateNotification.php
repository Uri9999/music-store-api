<?php

namespace App\Jobs;

use App\Interfaces\NotificationServiceInterface;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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

    static public function createOrder(User $user, Order $order)
    {
        self::dispatch([
            'type' => Notification::TYPE_CREATE_ORDER,
            'user_id' => $user->getKey(),
            'title' => 'Thông báo đơn hàng tạo thành công',
            'body' => 'Bạn đã tạo đơn hàng thành công lúc: ' . $order->created_at->format('d-m-Y H:i:s') . ' . Chúng tôi sẽ phản hồi sớm nhất!',
        ]);
    }
}
