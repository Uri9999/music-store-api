<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email;
    public $newPassword;

    public function __construct($email, $newPassword)
    {
        $this->email = $email;
        $this->newPassword = $newPassword;
    }

    public function build()
    {
        return $this->subject('Mật khẩu mới từ Zumi Shop')
            ->view('emails.reset_password')
            ->with([
                'email' => $this->email,
                'newPassword' => $this->newPassword
            ]);
    }
}
