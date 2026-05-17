<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MahasiswaResetPasswordMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public User $user,
        public string $resetLink,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Reset Password E-Portfolio Mahasiswa')
            ->view('emails.mahasiswa-reset-password');
    }
}