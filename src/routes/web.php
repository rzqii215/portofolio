<?php

use App\Http\Middleware\EnsureMahasiswa;
use App\Livewire\Mahasiswa\Auth\ForgotPassword as MahasiswaForgotPassword;
use App\Livewire\Mahasiswa\Auth\Login as MahasiswaLogin;
use App\Livewire\Mahasiswa\Auth\Register as MahasiswaRegister;
use App\Livewire\Mahasiswa\Auth\ResetPassword as MahasiswaResetPassword;
use App\Livewire\Mahasiswa\Dashboard as MahasiswaDashboard;
use App\Livewire\Mahasiswa\Portofolio\Index as PortofolioIndex;
use App\Livewire\Mahasiswa\Portofolio\Show as PortofolioShow;
use App\Livewire\Mahasiswa\Prestasi\Create as MahasiswaPrestasiCreate;
use App\Livewire\Mahasiswa\Prestasi\Edit as MahasiswaPrestasiEdit;
use App\Livewire\Mahasiswa\Prestasi\Index as MahasiswaPrestasiIndex;
use App\Livewire\Mahasiswa\Profil\Edit as MahasiswaProfilEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', MahasiswaLogin::class)
        ->name('login');

    Route::get('/register', MahasiswaRegister::class)
        ->name('register');

    Route::get('/forgot-password', MahasiswaForgotPassword::class)
        ->name('password.request');

    Route::get('/reset-password/{token}', MahasiswaResetPassword::class)
        ->name('password.reset');
});

Route::get('/mahasiswa/login', function () {
    return redirect()->route('login');
})->name('mahasiswa.login');

Route::get('/portofolio', PortofolioIndex::class)
    ->name('portofolio.index');

Route::get('/portofolio/{slug}', PortofolioShow::class)
    ->name('portofolio.show');

Route::middleware(EnsureMahasiswa::class)
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', MahasiswaDashboard::class)
            ->name('dashboard');

        Route::get('/profil', MahasiswaProfilEdit::class)
            ->name('profil.edit');

        Route::get('/prestasi', MahasiswaPrestasiIndex::class)
            ->name('prestasi.index');

        Route::get('/prestasi/create', MahasiswaPrestasiCreate::class)
            ->name('prestasi.create');

        Route::get('/prestasi/{prestasi}/edit', MahasiswaPrestasiEdit::class)
            ->name('prestasi.edit');
    });

Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');