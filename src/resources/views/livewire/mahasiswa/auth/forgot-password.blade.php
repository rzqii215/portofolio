<div>
    @php
        use Illuminate\Support\Facades\Route;

        $loginRoute = Route::has('login') ? route('login') : url('/login');
        $registerRoute = Route::has('register') ? route('register') : url('/register');
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
                <form wire:submit.prevent="kirimLinkReset" class="ep-auth-card">
                    <div class="ep-logo ep-auth-logo">
                        <span>?</span>
                    </div>

                    <h1 class="ep-auth-title">
                        Lupa Password
                    </h1>

                    <p class="ep-auth-subtitle">
                        Masukkan email mahasiswa. Link reset password akan dikirim ke email tersebut.
                    </p>

                    @if (session('success'))
                        <div class="ep-alert ep-alert-success" style="margin-bottom: 18px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($emailSent ?? false)
                        <div class="ep-alert ep-alert-success" style="margin-bottom: 18px;">
                            Link reset password berhasil dikirim. Cek inbox, spam, atau promotion pada email kamu.
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
                                placeholder="Masukkan email terdaftar"
                                autocomplete="email"
                                autofocus
                            >
                        </div>

                        @error('email')
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
                            Kirim Link Reset Password
                        </span>

                        <span wire:loading>
                            Mengirim Email...
                        </span>
                    </button>

                    <div style="margin-top: 18px;" class="ep-alert ep-alert-warning">
                        Link reset password dikirim melalui email. Jika belum terlihat, cek folder Spam atau Promotions.
                    </div>

                    <div class="ep-divider">
                        Akses akun
                    </div>

                    <div class="ep-auth-links">
                        <a href="{{ $loginRoute }}" class="ep-auth-link">
                            Kembali ke Login
                        </a>

                        <a href="{{ $registerRoute }}" class="ep-auth-link">
                            Register Mahasiswa
                        </a>
                    </div>
                </form>

                <aside class="ep-auth-side">
                    <div class="ep-auth-illustration">
                        <div class="ep-auth-window">
                            <h2 style="margin: 0; color: #0f172a; font-size: 24px; line-height: 1.15; font-weight: 900; letter-spacing: -0.04em;">
                                Reset Password Aman
                            </h2>

                            <p style="margin: 10px 0 18px; color: #64748b; font-size: 14px; line-height: 1.7;">
                                Sistem akan membuat token reset password dan mengirimkannya ke email mahasiswa yang terdaftar.
                            </p>

                            <div style="display: grid; gap: 12px;">
                                <div class="ep-auth-window-line" style="width: 82%;"></div>
                                <div class="ep-auth-window-line" style="width: 64%;"></div>
                                <div class="ep-auth-window-line" style="width: 90%;"></div>
                            </div>

                            <div style="margin-top: 20px; display: inline-flex;" class="ep-badge ep-badge-green">
                                Email Integration Aktif
                            </div>
                        </div>
                    </div>

                    <div class="ep-auth-benefit">
                        <div class="ep-icon-circle green">
                            ✉
                        </div>

                        <div>
                            <h3>
                                Email Otomatis
                            </h3>

                            <p>
                                Link reset dikirim ke email mahasiswa menggunakan integrasi Brevo API.
                            </p>
                        </div>
                    </div>
                </aside>
            </section>
        </div>
    </main>
</div>