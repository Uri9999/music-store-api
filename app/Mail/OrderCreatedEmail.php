<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreatedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $username;
    public $orderId;

    public function __construct($username, $orderId)
    {
        $this->username = $username;
        $this->orderId = $orderId;
    }

    public function build()
    {
        return $this->subject('Có đơn hàng mới từ khách hàng ' . $this->username)
            ->view('emails.order_created')
            ->with([
                'username' => $this->username,
                'orderId' => $this->orderId,
            ]);
    }
}
