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
    public $verificationToken;
    public $expiresAt;

    public function __construct($email, $verificationToken, $expiresAt)
    {
        $this->email = $email;
        $this->verificationToken = $verificationToken;
        $this->expiresAt = $expiresAt;
    }

    public function build()
    {
        return $this->subject('Yêu cầu đăng ký tài khoản tới từ Zumi Shop')
            ->view('emails.verify_user')
            ->with([
                'email' => $this->email,
                'verificationToken' => $this->verificationToken,
                'expiresAt' => $this->expiresAt
            ]);
    }
}
