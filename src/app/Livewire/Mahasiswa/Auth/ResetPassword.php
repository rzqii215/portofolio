<?php

namespace App\Livewire\Mahasiswa\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.mahasiswa')]
class ResetPassword extends Component
{
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = (string) request()->query('email', '');
    }

    public function resetPassword()
    {
        $validated = $this->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->first();

        if (! $resetData) {
            $this->addError('email', 'Token reset password tidak ditemukan. Silakan buat link reset baru.');

            return;
        }

        $createdAt = Carbon::parse($resetData->created_at);

        if ($createdAt->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('email', $validated['email'])
                ->delete();

            $this->addError('email', 'Token reset password sudah kadaluarsa. Silakan buat link reset baru.');

            return;
        }

        $tokenIsValid = false;

        if (Hash::check($this->token, $resetData->token)) {
            $tokenIsValid = true;
        }

        if (hash_equals((string) $resetData->token, $this->token)) {
            $tokenIsValid = true;
        }

        if (! $tokenIsValid) {
            $this->addError('email', 'Token reset password tidak valid.');

            return;
        }

        $user = User::query()
            ->where('email', $validated['email'])
            ->firstOrFail();

        $user->forceFill([
            'password' => Hash::make($validated['password']),
            'remember_token' => null,
        ])->save();

        DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->delete();

        session()->flash('success', 'Password berhasil diperbarui. Silakan login menggunakan password baru.');

        return redirect()->route('login');
    }

    public function render(): View
    {
        return view('livewire.mahasiswa.auth.reset-password');
    }
}