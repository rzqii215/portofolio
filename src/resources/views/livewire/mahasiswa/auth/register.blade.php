<div>
    @php
        use Illuminate\Support\Facades\Route;

        $loginRoute = Route::has('login') ? route('login') : url('/login');
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
                <form wire:submit.prevent="register" class="ep-auth-card">
                    <div class="ep-logo ep-auth-logo">
                        <span>E</span>
                    </div>

                    <h1 class="ep-auth-title">
                        Register Mahasiswa
                    </h1>

                    <p class="ep-auth-subtitle">
                        Buat akun untuk mulai mengelola profil, mengajukan prestasi, dan membangun portofolio public.
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
                            Nama Lengkap
                        </label>

                        <div class="ep-field-icon">
                            <span class="left-icon">👤</span>

                            <input
                                type="text"
                                wire:model="name"
                                placeholder="Masukkan nama lengkap"
                                autocomplete="name"
                                autofocus
                            >
                        </div>

                        @error('name')
                            <p class="ep-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ep-form-group">
                        <label class="ep-form-label">
                            Email
                        </label>

                        <div class="ep-field-icon">
                            <span class="left-icon">✉</span>

                            <input
                                type="email"
                                wire:model="email"
                                placeholder="Masukkan email aktif"
                                autocomplete="email"
                            >
                        </div>

                        @error('email')
                            <p class="ep-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ep-form-group">
                        <label class="ep-form-label">
                            Password
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
                            Konfirmasi Password
                        </label>

                        <div class="ep-field-icon">
                            <span class="left-icon">●</span>

                            <input
                                type="password"
                                wire:model="password_confirmation"
                                placeholder="Ulangi password"
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
                            Buat Akun
                        </span>

                        <span wire:loading>
                            Menyimpan...
                        </span>
                    </button>

                    <div class="ep-divider">
                        Sudah punya akun?
                    </div>

                    <a href="{{ $loginRoute }}" class="ep-auth-link" style="width: 100%;">
                        Login Mahasiswa
                    </a>
                </form>

                <aside class="ep-auth-side">
                    <div class="ep-auth-illustration">
                        <div class="ep-auth-window">
                            <h2 style="margin: 0; color: #0f172a; font-size: 24px; line-height: 1.15; font-weight: 900; letter-spacing: -0.04em;">
                                Mulai Bangun Portofolio Prestasimu.
                            </h2>

                            <p style="margin: 10px 0 18px; color: #64748b; font-size: 14px; line-height: 1.7;">
                                Setelah register, akun akan tersimpan dan kamu bisa login untuk melengkapi profil mahasiswa.
                            </p>

                            <div style="display: grid; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 12px; padding: 13px; border-radius: 16px; background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <span style="width: 38px; height: 38px; border-radius: 13px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 900;">1</span>
                                    <strong style="font-size: 14px;">Register akun mahasiswa</strong>
                                </div>

                                <div style="display: flex; align-items: center; gap: 12px; padding: 13px; border-radius: 16px; background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <span style="width: 38px; height: 38px; border-radius: 13px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-weight: 900;">2</span>
                                    <strong style="font-size: 14px;">Lengkapi profil dan slug public</strong>
                                </div>

                                <div style="display: flex; align-items: center; gap: 12px; padding: 13px; border-radius: 16px; background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <span style="width: 38px; height: 38px; border-radius: 13px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-weight: 900;">3</span>
                                    <strong style="font-size: 14px;">Ajukan prestasi ke admin</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ep-auth-benefit">
                        <div class="ep-icon-circle purple">
                            ✦
                        </div>

                        <div>
                            <h3>
                                Siap Untuk Publikasi
                            </h3>

                            <p>
                                Profil dan prestasi tervalidasi bisa ditampilkan sebagai portofolio public.
                            </p>
                        </div>
                    </div>
                </aside>
            </section>
        </div>
    </main>
</div>