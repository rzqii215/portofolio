<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'E-Portfolio Prestasi Mahasiswa' }}</title>

    <meta
        name="description"
        content="Dashboard mahasiswa untuk mengelola profil, pengajuan prestasi, validasi, dan portofolio public."
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

        $isAuthPage = request()->routeIs('login')
            || request()->routeIs('register')
            || request()->routeIs('password.*')
            || request()->is('forgot-password')
            || request()->is('reset-password*');

        $homeRoute = Route::has('home') ? route('home', [], false) : '/';
        $loginRoute = Route::has('login') ? route('login', [], false) : '/login';
        $registerRoute = Route::has('register') ? route('register', [], false) : '/register';
        $logoutRoute = Route::has('logout') ? route('logout', [], false) : '/logout';

        $dashboardRoute = Route::has('mahasiswa.dashboard') ? route('mahasiswa.dashboard', [], false) : '/mahasiswa/dashboard';
        $profilRoute = Route::has('mahasiswa.profil.edit') ? route('mahasiswa.profil.edit', [], false) : '/mahasiswa/profil';
        $prestasiRoute = Route::has('mahasiswa.prestasi.index') ? route('mahasiswa.prestasi.index', [], false) : '/mahasiswa/prestasi';
        $publicRoute = Route::has('portofolio.index') ? route('portofolio.index', [], false) : '/portofolio';
    @endphp

    @if ($isAuthPage)
        {{ $slot }}

        @livewireScripts
    @else
        <div class="ep-shell">
            <header class="ep-topbar no-print">
                <div class="ep-container">
                    <nav class="ep-navbar">
                        <a href="{{ auth()->check() ? $dashboardRoute : $homeRoute }}" class="ep-brand">
                            <span class="ep-logo">
                                <span>E</span>
                            </span>

                            <span class="ep-brand-text">
                                <strong>E-Portfolio</strong>
                                <small>Prestasi Mahasiswa</small>
                            </span>
                        </a>

                        <div class="ep-nav">
                            @auth
                                <a
                                    href="{{ $dashboardRoute }}"
                                    class="ep-nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"
                                >
                                    Dashboard
                                </a>

                                <a
                                    href="{{ $profilRoute }}"
                                    class="ep-nav-link {{ request()->routeIs('mahasiswa.profil.*') ? 'active' : '' }}"
                                >
                                    Profil
                                </a>

                                <a
                                    href="{{ $prestasiRoute }}"
                                    class="ep-nav-link {{ request()->routeIs('mahasiswa.prestasi.*') ? 'active' : '' }}"
                                >
                                    Prestasi
                                </a>

                                <form method="POST" action="{{ $logoutRoute }}">
                                    @csrf

                                    <button type="submit" class="ep-nav-button danger">
                                        Logout
                                    </button>
                                </form>
                            @else
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

                                <a
                                    href="{{ $loginRoute }}"
                                    class="ep-nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                                >
                                    Login
                                </a>

                                <a
                                    href="{{ $registerRoute }}"
                                    class="ep-nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                                >
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
                            <span>— Pengajuan, validasi, dan publikasi prestasi mahasiswa.</span>
                        </div>

                        <div>
                            © {{ date('Y') }} Portofolio.
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        @livewireScripts
    @endif
</body>
</html>