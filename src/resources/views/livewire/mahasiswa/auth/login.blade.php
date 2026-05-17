<div>
    @php
        use Illuminate\Support\Facades\Route;

        $homeRoute = Route::has('home') ? route('home', [], false) : '/';
        $registerRoute = Route::has('register') ? route('register', [], false) : '/register';
        $forgotRoute = Route::has('password.request') ? route('password.request', [], false) : '/forgot-password';
    @endphp

    <style>
        .login-page {
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
            background:
                radial-gradient(circle at 8% 88%, rgba(37, 99, 235, 0.22), transparent 280px),
                radial-gradient(circle at 96% 92%, rgba(59, 130, 246, 0.24), transparent 320px),
                linear-gradient(135deg, #061633 0%, #082764 48%, #0b3b8f 100%);
            padding: 28px 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1080px;
            margin: 0 auto;
        }

        .login-brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: #ffffff;
            margin-bottom: 28px;
        }

        .login-brand-logo {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background:
                radial-gradient(circle at 70% 70%, #f59e0b 0 5px, transparent 6px),
                linear-gradient(145deg, #eff6ff, #ffffff);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.20);
            color: #2563eb;
            font-weight: 950;
            font-size: 26px;
            letter-spacing: -0.08em;
        }

        .login-brand-text strong {
            display: block;
            color: #ffffff;
            font-size: 23px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .login-brand-text span {
            display: block;
            margin-top: 4px;
            color: #dbeafe;
            font-size: 14px;
            font-weight: 800;
        }

        .login-grid {
            display: grid;
            grid-template-columns: 500px 500px;
            gap: 40px;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.72);
            border-radius: 34px;
            padding: 40px 36px;
            box-shadow:
                0 34px 90px rgba(2, 6, 23, 0.28),
                inset 0 1px 0 rgba(255, 255, 255, 0.96);
            box-sizing: border-box;
        }

        .login-form-logo {
            width: 68px;
            height: 68px;
            border-radius: 22px;
            background:
                radial-gradient(circle at 72% 72%, #f59e0b 0 5px, transparent 6px),
                linear-gradient(145deg, #eff6ff, #ffffff);
            color: #1d4ed8;
            margin: 0 auto 22px;
            box-shadow: 0 18px 40px rgba(37, 99, 235, 0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 950;
            letter-spacing: -0.08em;
        }

        .login-title {
            margin: 0;
            text-align: center;
            color: #07152f;
            font-size: 40px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.06em;
        }

        .login-subtitle {
            max-width: 410px;
            margin: 14px auto 30px;
            text-align: center;
            color: #64748b;
            font-size: 16px;
            line-height: 1.75;
            font-weight: 700;
        }

        .login-alert {
            border-radius: 18px;
            padding: 14px 16px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 800;
        }

        .login-alert-success {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .login-alert-danger {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        .login-form-group {
            margin-bottom: 20px;
        }

        .login-label {
            display: block;
            margin-bottom: 9px;
            color: #07152f;
            font-size: 15px;
            font-weight: 950;
        }

        .login-input {
            width: 100%;
            height: 58px;
            border-radius: 18px;
            border: 1px solid #cbd5e1;
            background: #f8fbff;
            color: #07152f;
            padding: 0 18px;
            font-size: 16px;
            font-weight: 700;
            outline: none;
            transition: 0.18s ease;
            box-sizing: border-box;
        }

        .login-input::placeholder {
            color: #94a3b8;
            font-weight: 700;
        }

        .login-input:focus {
            border-color: #2563eb;
            background: #ffffff;
            box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.14);
        }

        .login-error {
            margin: 8px 0 0;
            color: #dc2626;
            font-size: 13px;
            font-weight: 800;
        }

        .login-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            margin: 4px 0 24px;
        }

        .login-check {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #475569;
            font-size: 14px;
            font-weight: 850;
            cursor: pointer;
        }

        .login-check input {
            width: 18px;
            height: 18px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        .login-link {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 950;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            min-height: 58px;
            border: 0;
            border-radius: 18px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            font-size: 16px;
            font-weight: 950;
            cursor: pointer;
            box-shadow: 0 18px 38px rgba(37, 99, 235, 0.28);
            transition: 0.18s ease;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 22px 46px rgba(37, 99, 235, 0.34);
        }

        .login-btn:disabled {
            opacity: 0.75;
            cursor: wait;
        }

        .login-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 28px 0 20px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 850;
        }

        .login-divider::before,
        .login-divider::after {
            content: "";
            height: 1px;
            flex: 1;
            background: #e2e8f0;
        }

        .login-register {
            width: 100%;
            min-height: 56px;
            border-radius: 18px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 15px;
            font-weight: 950;
            border: 1px solid #dbeafe;
            transition: 0.18s ease;
        }

        .login-register:hover {
            background: #dbeafe;
        }

        .login-side {
            display: grid;
            gap: 22px;
            width: 100%;
        }

        .login-preview-wrap {
            border-radius: 34px;
            padding: 24px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow: 0 30px 80px rgba(2, 6, 23, 0.24);
            backdrop-filter: blur(18px);
            box-sizing: border-box;
        }

        .login-preview {
            border-radius: 28px;
            background: #ffffff;
            padding: 28px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        .login-preview-head {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }

        .login-preview-avatar {
            width: 66px;
            height: 66px;
            border-radius: 20px;
            background: #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 28px;
            font-weight: 950;
        }

        .login-preview-title {
            margin: 0;
            color: #07152f;
            font-size: 24px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .login-preview-text {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 700;
        }

        .login-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .login-stat {
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 15px;
            background: #f8fbff;
        }

        .login-stat span {
            display: block;
            color: #64748b;
            font-size: 12px;
            font-weight: 950;
        }

        .login-stat strong {
            display: block;
            margin-top: 5px;
            color: #07152f;
            font-size: 31px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.06em;
        }

        .login-stat.valid strong {
            color: #16a34a;
        }

        .login-stat.review strong {
            color: #d97706;
        }

        .login-info-card {
            display: grid;
            grid-template-columns: 62px 1fr;
            gap: 18px;
            align-items: center;
            border-radius: 26px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow: 0 18px 48px rgba(2, 6, 23, 0.16);
            color: #ffffff;
            backdrop-filter: blur(16px);
        }

        .login-info-icon {
            width: 62px;
            height: 62px;
            border-radius: 19px;
            background: rgba(255, 255, 255, 0.92);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 28px;
            font-weight: 950;
        }

        .login-info-card.green .login-info-icon {
            color: #16a34a;
            background: #dcfce7;
        }

        .login-info-card h3 {
            margin: 0;
            color: #ffffff;
            font-size: 20px;
            line-height: 1.25;
            font-weight: 950;
            letter-spacing: -0.035em;
        }

        .login-info-card p {
            margin: 5px 0 0;
            color: #dbeafe;
            font-size: 14px;
            line-height: 1.65;
            font-weight: 700;
        }

        @media (max-width: 1120px) {
            .login-wrapper {
                max-width: 620px;
            }

            .login-grid {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .login-side {
                display: none;
            }

            .login-brand {
                display: flex;
                width: max-content;
                margin-left: auto;
                margin-right: auto;
            }
        }

        @media (max-width: 640px) {
            .login-page {
                padding: 20px 14px;
            }

            .login-brand-logo {
                width: 50px;
                height: 50px;
                border-radius: 16px;
                font-size: 24px;
            }

            .login-brand-text strong {
                font-size: 20px;
            }

            .login-card {
                border-radius: 28px;
                padding: 28px 20px;
            }

            .login-title {
                font-size: 32px;
            }

            .login-subtitle {
                font-size: 14px;
            }
        }
    </style>

    <main class="login-page">
        <div class="login-wrapper">
            <a href="{{ $homeRoute }}" class="login-brand">
                <span class="login-brand-logo">
                    E
                </span>

                <span class="login-brand-text">
                    <strong>E-Portfolio</strong>
                    <span>Prestasi Mahasiswa</span>
                </span>
            </a>

            <section class="login-grid">
                <form wire:submit.prevent="login" class="login-card">
                    <div class="login-form-logo">
                        E
                    </div>

                    <h1 class="login-title">
                        Login Mahasiswa
                    </h1>

                    <p class="login-subtitle">
                        Masuk untuk mengelola profil, mengajukan prestasi, dan memantau validasi portofolio kamu.
                    </p>

                    @if (session('success'))
                        <div class="login-alert login-alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="login-alert login-alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="login-form-group">
                        <label class="login-label" for="email">
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            wire:model="email"
                            class="login-input"
                            placeholder="Masukkan email mahasiswa"
                            autocomplete="email"
                            autofocus
                        >

                        @error('email')
                            <p class="login-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="login-form-group">
                        <label class="login-label" for="password">
                            Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            wire:model="password"
                            class="login-input"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >

                        @error('password')
                            <p class="login-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="login-row">
                        <label class="login-check">
                            <input
                                type="checkbox"
                                wire:model="remember"
                            >

                            <span>
                                Ingat saya
                            </span>
                        </label>

                        <a href="{{ $forgotRoute }}" class="login-link">
                            Lupa password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="login-btn"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>
                            Masuk
                        </span>

                        <span wire:loading>
                            Memproses...
                        </span>
                    </button>

                    <div class="login-divider">
                        Belum punya akun?
                    </div>

                    <a href="{{ $registerRoute }}" class="login-register">
                        Register Mahasiswa
                    </a>
                </form>

                <aside class="login-side">
                    <div class="login-preview-wrap">
                        <div class="login-preview">
                            <div class="login-preview-head">
                                <div class="login-preview-avatar">
                                    M
                                </div>

                                <div>
                                    <h2 class="login-preview-title">
                                        Dashboard Prestasi
                                    </h2>

                                    <p class="login-preview-text">
                                        Pantau validasi dan status portofolio.
                                    </p>
                                </div>
                            </div>

                            <div class="login-stats">
                                <div class="login-stat">
                                    <span>Total</span>
                                    <strong>3</strong>
                                </div>

                                <div class="login-stat valid">
                                    <span>Valid</span>
                                    <strong>2</strong>
                                </div>

                                <div class="login-stat review">
                                    <span>Review</span>
                                    <strong>1</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="login-info-card">
                        <div class="login-info-icon">
                            ✓
                        </div>

                        <div>
                            <h3>
                                Validasi Admin
                            </h3>

                            <p>
                                Setiap prestasi yang diajukan akan melalui proses validasi admin sebelum ditampilkan.
                            </p>
                        </div>
                    </div>

                    <div class="login-info-card green">
                        <div class="login-info-icon">
                            🌐
                        </div>

                        <div>
                            <h3>
                                Portofolio Public
                            </h3>

                            <p>
                                Prestasi yang sudah disetujui dapat ditampilkan pada halaman public sebagai portofolio mahasiswa.
                            </p>
                        </div>
                    </div>
                </aside>
            </section>
        </div>
    </main>
</div>