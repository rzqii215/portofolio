<?php

namespace App\Livewire\Mahasiswa\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Throwable;

#[Layout('layouts.mahasiswa')]
class ForgotPassword extends Component
{
    public string $email = '';

    public bool $emailSent = false;

    public function kirimLinkReset(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::query()
            ->where('email', $validated['email'])
            ->firstOrFail();

        if (! $user->hasRole('mahasiswa')) {
            $this->addError('email', 'Reset password ini hanya untuk akun mahasiswa.');

            return;
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            [
                'email' => $validated['email'],
            ],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $resetLink = route('password.reset', [
            'token' => $token,
            'email' => $validated['email'],
        ]);

        $apiKey = config('brevo.api_key');
        $senderEmail = config('brevo.sender_email');
        $senderName = config('brevo.sender_name');

        if (! $apiKey || ! $senderEmail) {
            $this->addError('email', 'Konfigurasi Brevo belum lengkap. Periksa BREVO_API_KEY dan BREVO_SENDER_EMAIL di file .env.');

            return;
        }

        $htmlContent = view('emails.mahasiswa-reset-password', [
            'user' => $user,
            'resetLink' => $resetLink,
        ])->render();

        $payload = [
            'sender' => [
                'name' => $senderName,
                'email' => $senderEmail,
            ],
            'to' => [
                [
                    'email' => $user->email,
                    'name' => $user->name,
                ],
            ],
            'subject' => 'Reset Password E-Portfolio Mahasiswa',
            'htmlContent' => $htmlContent,
        ];

        try {
            Log::info('Brevo reset password request', [
                'sender_email' => $senderEmail,
                'sender_name' => $senderName,
                'to' => $user->email,
                'subject' => 'Reset Password E-Portfolio Mahasiswa',
            ]);

            $response = Http::timeout(30)
                ->acceptJson()
                ->asJson()
                ->withHeaders([
                    'api-key' => $apiKey,
                ])
                ->post('https://api.brevo.com/v3/smtp/email', $payload);

            Log::info('Brevo reset password response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if (! $response->successful()) {
                $message = $response->json('message') ?: $response->body();

                $this->addError('email', 'Brevo error ' . $response->status() . ': ' . $message);

                return;
            }

            $messageId = $response->json('messageId') ?? '-';

            $this->emailSent = true;

            session()->flash('success', 'Link reset password berhasil dikirim ke email kamu. Brevo Message ID: ' . $messageId);
        } catch (Throwable $exception) {
            Log::error('Brevo reset password exception', [
                'message' => $exception->getMessage(),
            ]);

            report($exception);

            $this->addError('email', 'Email gagal dikirim. Periksa koneksi internet, API Key Brevo, dan sender email yang sudah diverifikasi.');
        }
    }

    public function render(): View
    {
        return view('livewire.mahasiswa.auth.forgot-password');
    }
}