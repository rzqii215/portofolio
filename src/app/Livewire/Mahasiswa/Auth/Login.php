<?php

namespace App\Livewire\Mahasiswa\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.mahasiswa')]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function mount(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return;
        }

        if ($user->hasAnyRole(['admin', 'super_admin'])) {
            $this->redirect('/admin', navigate: false);

            return;
        }

        if ($user->hasRole('mahasiswa')) {
            $this->redirectRoute('mahasiswa.dashboard', navigate: false);
        }
    }

    public function login(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($validated, $this->remember)) {
            $this->addError('email', 'Email atau password tidak sesuai.');

            return;
        }

        session()->regenerate();

        $user = Auth::user();

        if (! $user instanceof User) {
            Auth::logout();

            session()->invalidate();
            session()->regenerateToken();

            $this->addError('email', 'Akun tidak valid.');

            return;
        }

        if ($user->hasAnyRole(['admin', 'super_admin'])) {
            $this->redirect('/admin', navigate: false);

            return;
        }

        if (! $user->hasRole('mahasiswa')) {
            Auth::logout();

            session()->invalidate();
            session()->regenerateToken();

            $this->addError('email', 'Akun ini tidak memiliki akses sebagai mahasiswa.');

            return;
        }

        $this->redirectRoute('mahasiswa.dashboard', navigate: false);
    }

    public function render(): View
    {
        return view('livewire.mahasiswa.auth.login');
    }
}