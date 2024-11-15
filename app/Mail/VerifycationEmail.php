<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifycationEmail extends Mailable
{
    use SerializesModels;
    // use Queueable, SerializesModels;

    public $verificationToken;
    public $expiresAt;

    public function __construct($verificationToken, $expiresAt)
    {
        $this->verificationToken = $verificationToken;
        $this->expiresAt = $expiresAt;
    }

    public function build()
    {
        return $this->subject('Yêu cầu đăng ký tài khoản tới từ Zumi Shop')
            ->view('emails.verify_user')
            ->with([
                'verificationToken' => $this->verificationToken,
                'expiresAt' => $this->expiresAt
            ]);
    }
}
