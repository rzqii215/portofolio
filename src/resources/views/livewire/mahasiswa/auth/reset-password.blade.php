<div>
    @php
        use Illuminate\Support\Facades\Route;

        $loginRoute = Route::has('login') ? route('login') : url('/login');
        $forgotRoute = Route::has('password.request') ? route('password.request') : url('/forgot-password');
        $homeRoute = Route::has('home') ? route('home') : url('/');
    @endphp

    <main class="ep-auth-page">
        <div class="ep-container">
            <div class="ep-auth-brand">
                <a href="{{ $homeRoute }}" class="ep-brand">
                    <span class="ep-logo">
                        <span>E</span>
                    </span>

                    <span class="ep-brand-text">
                        <strong>E-Portfolio</strong>
                        <small>Prestasi Mahasiswa</small>
                    </span>
                </a>
            </div>

            <section class="ep-auth-grid">
                <form wire:submit.prevent="resetPassword" class="ep-auth-card">
                    <div class="ep-logo ep-auth-logo">
                        <span>↻</span>
                    </div>

                    <h1 class="ep-auth-title">
                        Reset Password
                    </h1>

                    <p class="ep-auth-subtitle">
                        Masukkan password baru untuk mengakses kembali dashboard E-Portfolio Prestasi Mahasiswa.
                    </p>

                    @if (session('success'))
                        <div class="ep-alert ep-alert-success" style="margin-bottom: 18px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="ep-alert ep-alert-danger" style="margin-bottom: 18px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="ep-form-group">
                        <label class="ep-form-label">
                            Email
                        </label>

                        <div class="ep-field-icon">
                            <span class="left-icon">✉</span>

                            <input
                                type="email"
                                wire:model="email"
                                placeholder="Email akun mahasiswa"
                                autocomplete="email"
                                readonly
                            >
                        </div>

                        @error('email')
                            <p class="ep-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ep-form-group">
                        <label class="ep-form-label">
                            Password Baru
                        </label>

                        <div class="ep-field-icon">
                            <span class="left-icon">●</span>

                            <input
                                type="password"
                                wire:model="password"
                                placeholder="Minimal 8 karakter"
                                autocomplete="new-password"
                            >
                        </div>

                        @error('password')
                            <p class="ep-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ep-form-group">
                        <label class="ep-form-label">
                            Konfirmasi Password Baru
                        </label>

                        <div class="ep-field-icon">
                            <span class="left-icon">●</span>

                            <input
                                type="password"
                                wire:model="password_confirmation"
                                placeholder="Ulangi password baru"
                                autocomplete="new-password"
                            >
                        </div>

                        @error('password_confirmation')
                            <p class="ep-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="ep-btn ep-btn-primary"
                        style="width: 100%;"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>
                            Simpan Password Baru
                        </span>

                        <span wire:loading>
                            Menyimpan...
                        </span>
                    </button>

                    <div class="ep-divider">
                        Link bermasalah?
                    </div>

                    <div class="ep-auth-links">
                        <a href="{{ $forgotRoute }}" class="ep-auth-link">
                            Buat Link Baru
                        </a>

                        <a href="{{ $loginRoute }}" class="ep-auth-link">
                            Kembali ke Login
                        </a>
                    </div>
                </form>

                <aside class="ep-auth-side">
                    <div class="ep-auth-illustration">
                        <div class="ep-auth-window">
                            <h2 style="margin: 0; color: #0f172a; font-size: 24px; line-height: 1.15; font-weight: 900; letter-spacing: -0.04em;">
                                Amankan Akun Kamu
                            </h2>

                            <p style="margin: 10px 0 18px; color: #64748b; font-size: 14px; line-height: 1.7;">
                                Setelah password berhasil diperbarui, gunakan password baru tersebut untuk login ke dashboard mahasiswa.
                            </p>

                            <div style="display: grid; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: #16a34a; font-size: 14px; font-weight: 900;">
                                    <span>✓</span>
                                    Minimal 8 karakter
                                </div>

                                <div style="display: flex; align-items: center; gap: 10px; color: #16a34a; font-size: 14px; font-weight: 900;">
                                    <span>✓</span>
                                    Token reset berlaku 60 menit
                                </div>

                                <div style="display: flex; align-items: center; gap: 10px; color: #16a34a; font-size: 14px; font-weight: 900;">
                                    <span>✓</span>
                                    Login kembali setelah berhasil
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ep-auth-benefit">
                        <div class="ep-icon-circle green">
                            🔒
                        </div>

                        <div>
                            <h3>
                                Reset Aman
                            </h3>

                            <p>
                                Link reset hanya bisa dipakai oleh email yang terdaftar dan token yang valid.
                            </p>
                        </div>
                    </div>
                </aside>
            </section>
        </div>
    </main>
</div>