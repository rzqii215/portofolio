<?php

namespace App\Livewire\Mahasiswa\Auth;

use App\Models\PengaturanPortofolio;
use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.mahasiswa')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Silakan login.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        DB::transaction(function () use ($validated): void {
            $user = User::query()->create([
                'name' => $validated['name'],
                'email' => strtolower($validated['email']),
                'password' => Hash::make($validated['password']),
            ]);

            if (method_exists($user, 'assignRole')) {
                try {
                    $user->assignRole('mahasiswa');
                } catch (\Throwable $th) {
                    //
                }
            }

            $profilMahasiswa = ProfilMahasiswa::query()->create([
                'user_id' => $user->id,
                'nim' => $this->generateTemporaryNim($user->id),
                'nomor_hp' => '',
                'program_studi' => '',
                'fakultas' => '',
                'angkatan' => '',
                'alamat' => '',
                'foto' => null,
                'bio' => '',
            ]);

            PengaturanPortofolio::query()->create([
                'profil_mahasiswa_id' => $profilMahasiswa->id,
                'slug_public' => $this->generateUniqueSlug($validated['name']),
                'public' => false,
                'tema' => 'default',
            ]);
        });

        Auth::logout();

        session()->flash('success', 'Akun berhasil dibuat. Silakan login menggunakan email dan password kamu.');

        return redirect()->route('login');
    }

    private function generateTemporaryNim(int $userId): string
    {
        return 'REG-' . str_pad((string) $userId, 6, '0', STR_PAD_LEFT);
    }

    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'mahasiswa';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            PengaturanPortofolio::query()
                ->where('slug_public', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function render(): View
    {
        return view('livewire.mahasiswa.auth.register');
    }
}