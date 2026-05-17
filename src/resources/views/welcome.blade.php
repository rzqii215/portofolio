<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>E-Portfolio Prestasi Mahasiswa</title>

    <meta
        name="description"
        content="Sistem informasi E-Portfolio Prestasi Mahasiswa untuk pengajuan, validasi, dan publikasi prestasi mahasiswa."
    >

    <link
        rel="stylesheet"
        href="/css/user-ui.css?v={{ file_exists(public_path('css/user-ui.css')) ? filemtime(public_path('css/user-ui.css')) : time() }}"
    >

    <style>
        .ep-mobile-toggle {
            display: none;
        }

        .ep-mobile-button {
            display: none;
        }

        .landing-hero-grid {
            display: grid;
            grid-template-columns: 1fr 0.96fr;
            gap: 48px;
            align-items: center;
        }

        .landing-preview {
            background: #ffffff;
            color: var(--ep-text);
            border-radius: 30px;
            padding: 22px;
            box-shadow: 0 32px 90px rgba(15, 23, 42, 0.28);
        }

        .preview-shell {
            display: grid;
            grid-template-columns: 160px 1fr;
            min-height: 315px;
            overflow: hidden;
            border: 1px solid var(--ep-border);
            border-radius: 24px;
            background: #ffffff;
        }

        .preview-sidebar {
            border-right: 1px solid var(--ep-border);
            padding: 22px 18px;
            background: #f8fbff;
        }

        .preview-avatar {
            width: 72px;
            height: 72px;
            border-radius: 999px;
            margin: 0 auto 12px;
            background: linear-gradient(135deg, #bfdbfe, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 30px;
            font-weight: 900;
        }

        .preview-name {
            margin: 0;
            text-align: center;
            font-size: 14px;
            font-weight: 900;
        }

        .preview-major {
            margin: 4px 0 18px;
            color: var(--ep-muted);
            text-align: center;
            font-size: 11px;
            line-height: 1.4;
        }

        .preview-menu {
            display: grid;
            gap: 7px;
        }

        .preview-menu span {
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 11px;
            padding: 8px 9px;
            color: #475569;
            font-size: 11px;
            font-weight: 800;
        }

        .preview-menu span.active {
            background: var(--ep-primary-soft);
            color: var(--ep-primary-dark);
        }

        .preview-main {
            padding: 22px;
        }

        .preview-main h3 {
            margin: 0;
            color: var(--ep-text);
            font-size: 20px;
            font-weight: 900;
            letter-spacing: -0.03em;
        }

        .preview-main p {
            margin: 5px 0 16px;
            color: var(--ep-muted);
            font-size: 12px;
        }

        .preview-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 18px;
        }

        .preview-stat {
            border: 1px solid var(--ep-border);
            border-radius: 16px;
            padding: 12px;
            background: #ffffff;
        }

        .preview-stat small {
            display: block;
            color: var(--ep-muted);
            font-size: 10px;
            font-weight: 800;
        }

        .preview-stat strong {
            display: block;
            margin-top: 4px;
            color: var(--ep-text);
            font-size: 24px;
            line-height: 1;
            font-weight: 900;
        }

        .preview-content-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 14px;
        }

        .preview-chart,
        .preview-list {
            border: 1px solid var(--ep-border);
            border-radius: 18px;
            background: #ffffff;
            padding: 14px;
            min-height: 132px;
        }

        .chart-bars {
            display: flex;
            align-items: end;
            gap: 9px;
            height: 82px;
            margin-top: 18px;
        }

        .chart-bars span {
            flex: 1;
            border-radius: 8px 8px 0 0;
            background: linear-gradient(180deg, #60a5fa, #2563eb);
        }

        .preview-list-item {
            display: grid;
            gap: 4px;
            padding: 8px 0;
            border-bottom: 1px solid #edf2f7;
            font-size: 11px;
        }

        .preview-list-item:last-child {
            border-bottom: 0;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .feature-card {
            display: grid;
            grid-template-columns: 84px 1fr;
            gap: 18px;
            align-items: center;
            min-height: 150px;
        }

        .feature-card h3,
        .flow-item h3 {
            margin: 0;
            color: var(--ep-text);
            font-size: 19px;
            line-height: 1.3;
            font-weight: 900;
            letter-spacing: -0.03em;
        }

        .feature-card p,
        .flow-item p {
            margin: 8px 0 0;
            color: var(--ep-muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .soft-illustration {
            width: 84px;
            height: 84px;
            border-radius: 24px;
            background:
                radial-gradient(circle at 72% 24%, rgba(22, 163, 74, 0.18), transparent 26px),
                linear-gradient(145deg, #eff6ff, #ffffff);
            border: 1px solid #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ep-primary);
            font-size: 38px;
            box-shadow: var(--ep-shadow-sm);
        }

        .flow-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .flow-item {
            position: relative;
        }

        .flow-number {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            background: var(--ep-primary);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            margin-bottom: 16px;
            box-shadow: 0 12px 26px rgba(37, 99, 235, 0.24);
        }

        .landing-cta {
            display: grid;
            grid-template-columns: 230px 1fr auto;
            gap: 28px;
            align-items: center;
            background:
                radial-gradient(circle at top right, rgba(96, 165, 250, 0.30), transparent 26rem),
                linear-gradient(135deg, #2563eb, #0846c7);
            color: #ffffff;
            border-radius: 32px;
            padding: 32px;
            box-shadow: var(--ep-shadow-lg);
            overflow: hidden;
        }

        .landing-cta-illustration {
            min-height: 115px;
            border-radius: 24px;
            background:
                radial-gradient(circle at 70% 20%, rgba(255, 255, 255, 0.28), transparent 38px),
                rgba(255, 255, 255, 0.13);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 54px;
        }

        .landing-cta h2 {
            margin: 0;
            color: #ffffff;
            font-size: 30px;
            line-height: 1.15;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .landing-cta p {
            margin: 8px 0 0;
            color: #dbeafe;
            line-height: 1.7;
        }

        @media (max-width: 1050px) {
            .landing-hero-grid,
            .feature-grid,
            .flow-grid,
            .landing-cta {
                grid-template-columns: 1fr;
            }

            .landing-preview {
                display: none;
            }
        }

        @media (max-width: 760px) {
            .ep-topbar {
                position: relative !important;
                top: auto !important;
                z-index: 100;
            }

            .ep-topbar .ep-navbar {
                position: relative;
                min-height: 72px;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 14px;
                padding-left: 66px;
                box-sizing: border-box;
            }

            .ep-mobile-button {
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 50px;
                height: 50px;
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.10);
                border: 1px solid rgba(255, 255, 255, 0.16);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                gap: 6px;
                cursor: pointer;
                box-shadow: 0 14px 34px rgba(2, 6, 23, 0.18);
                flex-shrink: 0;
                margin: 0;
            }

            .ep-topbar .ep-brand {
                min-width: 0;
                max-width: 100%;
            }

            .ep-topbar .ep-brand-text {
                min-width: 0;
            }

            .ep-topbar .ep-brand-text strong {
                max-width: 180px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .ep-mobile-button span {
                width: 23px;
                height: 2.5px;
                border-radius: 999px;
                background: #ffffff;
                display: block;
                transition: 0.18s ease;
            }

            .ep-mobile-toggle:checked + .ep-mobile-button span:nth-child(1) {
                transform: translateY(8.5px) rotate(45deg);
            }

            .ep-mobile-toggle:checked + .ep-mobile-button span:nth-child(2) {
                opacity: 0;
            }

            .ep-mobile-toggle:checked + .ep-mobile-button span:nth-child(3) {
                transform: translateY(-8.5px) rotate(-45deg);
            }

            .ep-topbar .ep-nav {
                position: absolute;
                left: 0;
                right: auto;
                top: calc(100% + 12px);
                z-index: 99;
                width: min(290px, calc(100vw - 28px));
                display: none !important;
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 14px;
                border-radius: 26px;
                background:
                    radial-gradient(circle at top right, rgba(37, 99, 235, 0.35), transparent 190px),
                    rgba(10, 20, 44, 0.98);
                border: 1px solid rgba(255, 255, 255, 0.12);
                box-shadow: 0 26px 70px rgba(2, 6, 23, 0.36);
                backdrop-filter: blur(18px);
            }

            .ep-mobile-toggle:checked ~ .ep-nav {
                display: grid !important;
            }

            .ep-topbar .ep-nav .ep-nav-link {
                width: 100%;
                min-height: 50px;
                border-radius: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                box-sizing: border-box;
            }

            .ep-topbar .ep-nav .ep-nav-link.active {
                background: #2563eb;
                color: #ffffff;
                box-shadow: 0 14px 34px rgba(37, 99, 235, 0.28);
            }
        }

        @media (max-width: 680px) {
            .feature-card {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    @php
        use Illuminate\Support\Facades\Route;

        $loginRoute = Route::has('login') ? route('login', [], false) : '/login';
        $registerRoute = Route::has('register') ? route('register', [], false) : '/register';
        $dashboardRoute = Route::has('mahasiswa.dashboard') ? route('mahasiswa.dashboard', [], false) : '/mahasiswa/dashboard';
        $publicRoute = Route::has('portofolio.index') ? route('portofolio.index', [], false) : '/portofolio';
    @endphp

    <div class="ep-shell">
        <header class="ep-topbar">
            <div class="ep-container">
                <nav class="ep-navbar">
                    <a href="/" class="ep-brand">
                        <span class="ep-logo">
                            <span>E</span>
                        </span>

                        <span class="ep-brand-text">
                            <strong>E-Portfolio</strong>
                            <small>Prestasi Mahasiswa</small>
                        </span>
                    </a>

                    <input type="checkbox" id="ep-mobile-menu" class="ep-mobile-toggle">

                    <label for="ep-mobile-menu" class="ep-mobile-button" aria-label="Buka navigasi">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>

                    <div class="ep-nav">
                        <a href="/" class="ep-nav-link active">
                            Beranda
                        </a>

                        <a href="{{ $publicRoute }}" class="ep-nav-link">
                            Direktori
                        </a>

                        @auth
                            <a href="{{ $dashboardRoute }}" class="ep-nav-link">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ $loginRoute }}" class="ep-nav-link">
                                Login
                            </a>

                            <a href="{{ $registerRoute }}" class="ep-nav-link">
                                Register
                            </a>
                        @endauth
                    </div>
                </nav>
            </div>
        </header>

        <main class="ep-main">
            <section class="ep-hero">
                <div class="ep-hero-pattern"></div>

                <div class="ep-container">
                    <div class="ep-hero-inner">
                        <div class="landing-hero-grid">
                            <div>
                                <p class="ep-eyebrow">
                                    Platform Terpercaya untuk Prestasi Mahasiswa
                                </p>

                                <h1 class="ep-title">
                                    Kelola Prestasi Mahasiswa Secara <span>Rapi, Valid,</span> dan Siap <span>Dipublikasikan.</span>
                                </h1>

                                <p class="ep-subtitle">
                                    Ajukan prestasi dengan mudah, divalidasi oleh admin, dan tampilkan di portofolio public sebagai bukti pencapaian nyata yang membanggakan.
                                </p>

                                <div class="ep-actions">
                                    <a href="{{ $registerRoute }}" class="ep-btn ep-btn-primary">
                                        Register Mahasiswa
                                    </a>

                                    <a href="{{ $publicRoute }}" class="ep-btn ep-btn-white">
                                        Lihat Direktori
                                    </a>

                                    <a href="{{ $loginRoute }}" class="ep-btn ep-btn-ghost">
                                        Login Mahasiswa
                                    </a>
                                </div>
                            </div>

                            <div class="landing-preview">
                                <div class="preview-shell">
                                    <aside class="preview-sidebar">
                                        <div class="preview-avatar">
                                            A
                                        </div>

                                        <h3 class="preview-name">
                                            Andi Pratama
                                        </h3>

                                        <p class="preview-major">
                                            Teknik Informatika<br>
                                            Universitas Nusantara
                                        </p>

                                        <div class="preview-menu">
                                            <span class="active">Dashboard</span>
                                            <span>Profil Saya</span>
                                            <span>Pengajuan Prestasi</span>
                                            <span>Prestasi Saya</span>
                                            <span>Pengaturan</span>
                                        </div>
                                    </aside>

                                    <section class="preview-main">
                                        <h3>
                                            Halo, Andi Pratama
                                        </h3>

                                        <p>
                                            Kelola prestasi dan bangun portofolio terbaikmu.
                                        </p>

                                        <div class="preview-stats">
                                            <div class="preview-stat">
                                                <small>Total</small>
                                                <strong>12</strong>
                                            </div>

                                            <div class="preview-stat">
                                                <small>Proses</small>
                                                <strong>3</strong>
                                            </div>

                                            <div class="preview-stat">
                                                <small>Valid</small>
                                                <strong>9</strong>
                                            </div>

                                            <div class="preview-stat">
                                                <small>Public</small>
                                                <strong>7</strong>
                                            </div>
                                        </div>

                                        <div class="preview-content-grid">
                                            <div class="preview-chart">
                                                <strong style="font-size: 12px;">Statistik Prestasi</strong>

                                                <div class="chart-bars">
                                                    <span style="height: 34%;"></span>
                                                    <span style="height: 58%;"></span>
                                                    <span style="height: 47%;"></span>
                                                    <span style="height: 74%;"></span>
                                                    <span style="height: 64%;"></span>
                                                    <span style="height: 86%;"></span>
                                                </div>
                                            </div>

                                            <div class="preview-list">
                                                <strong style="font-size: 12px;">Status Terbaru</strong>

                                                <div class="preview-list-item">
                                                    <b>Lomba Karya Tulis</b>
                                                    <span style="color: #d97706;">Menunggu Validasi</span>
                                                </div>

                                                <div class="preview-list-item">
                                                    <b>Hackathon Nasional</b>
                                                    <span style="color: #16a34a;">Tervalidasi</span>
                                                </div>

                                                <div class="preview-list-item">
                                                    <b>Debat Mahasiswa</b>
                                                    <span style="color: #16a34a;">Tampil Public</span>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="ep-section">
                <div class="ep-container">
                    <div style="text-align: center; max-width: 760px; margin: 0 auto 28px;">
                        <h2 class="ep-section-title">
                            Fitur Utama
                        </h2>

                        <p class="ep-section-subtitle">
                            Sistem dibuat untuk memudahkan mahasiswa dan admin dalam pengajuan, validasi, dan publikasi prestasi.
                        </p>
                    </div>

                    <div class="feature-grid">
                        <article class="ep-card ep-card-pad feature-card">
                            <div class="soft-illustration">
                                📁
                            </div>

                            <div>
                                <h3>
                                    Pengajuan Prestasi
                                </h3>

                                <p>
                                    Ajukan berbagai prestasi akademik maupun non-akademik dengan mudah dan terstruktur.
                                </p>
                            </div>
                        </article>

                        <article class="ep-card ep-card-pad feature-card">
                            <div class="soft-illustration">
                                ✅
                            </div>

                            <div>
                                <h3>
                                    Validasi Admin
                                </h3>

                                <p>
                                    Setiap pengajuan diperiksa dan divalidasi admin untuk memastikan keabsahan data.
                                </p>
                            </div>
                        </article>

                        <article class="ep-card ep-card-pad feature-card">
                            <div class="soft-illustration">
                                🌐
                            </div>

                            <div>
                                <h3>
                                    Portofolio Public
                                </h3>

                                <p>
                                    Prestasi tervalidasi dapat tampil di portofolio public sebagai bukti pencapaian.
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="ep-section" style="padding-top: 0;">
                <div class="ep-container">
                    <div class="ep-card ep-card-pad">
                        <div style="text-align: center; max-width: 760px; margin: 0 auto 28px;">
                            <h2 class="ep-section-title">
                                Alur Sistem
                            </h2>

                            <p class="ep-section-subtitle">
                                Flow sederhana, jelas, dan nyaman digunakan untuk mahasiswa maupun admin.
                            </p>
                        </div>

                        <div class="flow-grid">
                            <article class="flow-item">
                                <div class="flow-number">1</div>

                                <h3>Register / Login</h3>

                                <p>
                                    Mahasiswa membuat akun atau login untuk mengakses sistem.
                                </p>
                            </article>

                            <article class="flow-item">
                                <div class="flow-number">2</div>

                                <h3>Lengkapi Profil</h3>

                                <p>
                                    Isi data diri, NIM, program studi, fakultas, dan informasi pendukung.
                                </p>
                            </article>

                            <article class="flow-item">
                                <div class="flow-number">3</div>

                                <h3>Ajukan Prestasi</h3>

                                <p>
                                    Upload data prestasi dan file bukti untuk dikirim ke admin.
                                </p>
                            </article>

                            <article class="flow-item">
                                <div class="flow-number">4</div>

                                <h3>Tampil Public</h3>

                                <p>
                                    Prestasi yang disetujui dapat tampil pada halaman portofolio public.
                                </p>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section class="ep-section" style="padding-top: 0;">
                <div class="ep-container">
                    <div class="landing-cta">
                        <div class="landing-cta-illustration">
                            🎓
                        </div>

                        <div>
                            <h2>
                                Mulai Kelola Prestasi Anda Sekarang!
                            </h2>

                            <p>
                                Bangun portofolio terbaik dan tunjukkan pencapaian Anda kepada dunia.
                            </p>
                        </div>

                        <a href="{{ $registerRoute }}" class="ep-btn ep-btn-white">
                            Register Mahasiswa
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="ep-footer">
            <div class="ep-container">
                <div class="ep-footer-inner">
                    <div>
                        <strong>E-Portfolio Prestasi Mahasiswa</strong>
                        <span>— Laravel, Livewire, Filament, MariaDB.</span>
                    </div>

                    <div>
                        © {{ date('Y') }} Portofolio.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>