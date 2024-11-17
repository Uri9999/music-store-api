<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable implements ShouldQueue
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
        return $this->subject('Xác thực quên mật khẩu Zumi Shop')
            ->view('emails.forgot_password')
            ->with([
                'email' => $this->email,
                'token' => $this->token,
                'expiresAt' => $this->expiresAt
            ]);
    }
}
