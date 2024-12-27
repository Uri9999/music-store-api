<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRevenueEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $username;
    public $month;
    public $commissionRate;
    public $orderItemsSumPrice;
    public $referralCommissionsSumPrice;

    public function __construct($username, $month, $commissionRate, $orderItemsSumPrice, $referralCommissionsSumPrice)
    {
        $this->username = $username;
        $this->month = $month;
        $this->commissionRate = $commissionRate;
        $this->orderItemsSumPrice = $orderItemsSumPrice;
        $this->referralCommissionsSumPrice = $referralCommissionsSumPrice;
    }

    public function build()
    {
        return $this->subject('Tổng kết doanh thu tháng ' . $this->month)
            ->view('emails.user_revenue')
            ->with([
                'username' => $this->username,
                'month' => $this->month,
                'tabSumPrice' => (($this->orderItemsSumPrice * $this->commissionRate) / 100),
                'subscriptionSumPrice' => (($this->referralCommissionsSumPrice * $this->commissionRate) / 100),
            ]);
    }
}
