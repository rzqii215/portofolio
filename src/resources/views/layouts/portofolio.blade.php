<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'E-Portfolio Prestasi Mahasiswa' }}</title>

    <meta
        name="description"
        content="Direktori portofolio public mahasiswa untuk menampilkan profil dan prestasi yang telah divalidasi admin."
    >

    <link
        rel="stylesheet"
        href="/css/user-ui.css?v={{ file_exists(public_path('css/user-ui.css')) ? filemtime(public_path('css/user-ui.css')) : time() }}"
    >

    @livewireStyles
</head>

<body>
    @php
        use Illuminate\Support\Facades\Route;

        $homeRoute = Route::has('home') ? route('home', [], false) : '/';
        $loginRoute = Route::has('login') ? route('login', [], false) : '/login';
        $registerRoute = Route::has('register') ? route('register', [], false) : '/register';
        $dashboardRoute = Route::has('mahasiswa.dashboard') ? route('mahasiswa.dashboard', [], false) : '/mahasiswa/dashboard';
        $publicRoute = Route::has('portofolio.index') ? route('portofolio.index', [], false) : '/portofolio';
    @endphp

    <div class="ep-shell">
        <header class="ep-topbar no-print">
            <div class="ep-container">
                <nav class="ep-navbar">
                    <a href="{{ $homeRoute }}" class="ep-brand">
                        <span class="ep-logo">
                            <span>E</span>
                        </span>

                        <span class="ep-brand-text">
                            <strong>E-Portfolio</strong>
                            <small>Prestasi Mahasiswa</small>
                        </span>
                    </a>

                    <div class="ep-nav">
                        <a
                            href="{{ $homeRoute }}"
                            class="ep-nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        >
                            Beranda
                        </a>

                        <a
                            href="{{ $publicRoute }}"
                            class="ep-nav-link {{ request()->routeIs('portofolio.*') ? 'active' : '' }}"
                        >
                            Direktori
                        </a>

                        @auth
                            <a href="{{ $dashboardRoute }}" class="ep-nav-link active">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ $loginRoute }}" class="ep-nav-link">
                                Login
                            </a>

                            <a href="{{ $registerRoute }}" class="ep-nav-link active">
                                Register
                            </a>
                        @endauth
                    </div>
                </nav>
            </div>
        </header>

        <main class="ep-main">
            {{ $slot }}
        </main>

        <footer class="ep-footer no-print">
            <div class="ep-container">
                <div class="ep-footer-inner">
                    <div>
                        <strong>E-Portfolio Prestasi Mahasiswa</strong>
                        <span>— Direktori public prestasi mahasiswa tervalidasi.</span>
                    </div>

                    <div>
                        © {{ date('Y') }} Portofolio.
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>