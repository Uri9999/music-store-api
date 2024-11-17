<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifycationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email;
    public $token;
    public $expiresAt;

    public function __construct($email, $token, $expiresAt)
    {
        $this->email = $email;
        $this->token = $token;
        $this->expiresAt = $expiresAt;
    }

    public function build()
    {
        return $this->subject('Yêu cầu đăng ký tài khoản tới từ Zumi Shop')
            ->view('emails.verify_user')
            ->with([
                'email' => $this->email,
                'token' => $this->token,
                'expiresAt' => $this->expiresAt
            ]);
    }
}
