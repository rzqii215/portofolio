<div>
    @php
        use Illuminate\Support\Facades\Route;
        use Illuminate\Support\Carbon;

        $nama = $user->name ?? 'Mahasiswa';
        $initial = strtoupper(substr($nama, 0, 1));

        $foto = $profilMahasiswa?->foto;
        $slug = $pengaturanPortofolio?->slug_public;
        $isPublic = (bool) ($pengaturanPortofolio?->public ?? false);

        $dashboardRoute = Route::has('mahasiswa.dashboard') ? route('mahasiswa.dashboard', [], false) : '/mahasiswa/dashboard';
        $profilRoute = Route::has('mahasiswa.profil.edit') ? route('mahasiswa.profil.edit', [], false) : '/mahasiswa/profil';
        $prestasiRoute = Route::has('mahasiswa.prestasi.index') ? route('mahasiswa.prestasi.index', [], false) : '/mahasiswa/prestasi';
        $createPrestasiRoute = Route::has('mahasiswa.prestasi.create') ? route('mahasiswa.prestasi.create', [], false) : '/mahasiswa/prestasi/create';
        $publicIndexRoute = Route::has('portofolio.index') ? route('portofolio.index', [], false) : '/portofolio';
        $publicShowRoute = $slug && Route::has('portofolio.show') ? route('portofolio.show', ['slug' => $slug], false) : null;

        $profileComplete = $profilMahasiswa
            && $profilMahasiswa->nim
            && $profilMahasiswa->program_studi
            && $profilMahasiswa->fakultas
            && $profilMahasiswa->angkatan;

        $totalForStatus = max(
            collect($statusChart)->sum('total'),
            1
        );

        $totalForTingkat = max(
            collect($tingkatChart)->sum('total'),
            1
        );
    @endphp

    <style>
        .student-dashboard-page {
            min-height: calc(100vh - 92px);
            background:
                radial-gradient(circle at 8% 12%, rgba(37, 99, 235, 0.10), transparent 280px),
                radial-gradient(circle at 94% 92%, rgba(14, 165, 233, 0.14), transparent 360px),
                linear-gradient(180deg, #edf5ff 0%, #f8fbff 50%, #eef6ff 100%);
            padding: 42px 22px 56px;
            box-sizing: border-box;
        }

        .student-dashboard-wrap {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
        }

        .student-dashboard-shell {
            background: #ffffff;
            border: 1px solid #dbe7f5;
            border-radius: 40px;
            box-shadow: 0 34px 90px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            display: grid;
            grid-template-columns: 285px 1fr;
            min-height: 650px;
        }

        .student-dashboard-side {
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.10), transparent 220px),
                linear-gradient(180deg, #f8fbff 0%, #f1f7ff 100%);
            border-right: 1px solid #dbe7f5;
            padding: 42px 30px;
        }

        .student-profile-box {
            text-align: center;
            margin-bottom: 32px;
        }

        .student-avatar {
            width: 112px;
            height: 112px;
            border-radius: 999px;
            margin: 0 auto 18px;
            background:
                radial-gradient(circle at 72% 24%, rgba(255, 255, 255, 0.38), transparent 28px),
                linear-gradient(145deg, #8ab4ff, #245ee8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 52px;
            font-weight: 950;
            letter-spacing: -0.08em;
            box-shadow: 0 18px 40px rgba(37, 99, 235, 0.24);
            overflow: hidden;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-name {
            margin: 0;
            color: #07152f;
            font-size: 23px;
            line-height: 1.18;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .student-major {
            margin: 8px 0 0;
            color: #52647d;
            font-size: 14px;
            line-height: 1.55;
            font-weight: 700;
        }

        .student-menu {
            display: grid;
            gap: 10px;
        }

        .student-menu-link {
            min-height: 50px;
            border-radius: 17px;
            padding: 0 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #334155;
            text-decoration: none;
            font-size: 15px;
            font-weight: 950;
            transition: 0.18s ease;
        }

        .student-menu-link:hover {
            background: #e8f1ff;
            color: #1d4ed8;
        }

        .student-menu-link.active {
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            color: #1d4ed8;
            box-shadow: inset 0 0 0 1px #bfdbfe;
        }

        .student-menu-icon {
            width: 30px;
            height: 30px;
            border-radius: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            color: #2563eb;
            font-size: 15px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        }

        .student-dashboard-main {
            padding: 44px 46px;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.05), transparent 280px),
                #ffffff;
        }

        .student-dashboard-header {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 22px;
            align-items: start;
            margin-bottom: 28px;
        }

        .student-greeting {
            margin: 0;
            color: #07152f;
            font-size: 36px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.06em;
        }

        .student-greeting-sub {
            max-width: 620px;
            margin: 12px 0 0;
            color: #52647d;
            font-size: 16px;
            line-height: 1.75;
            font-weight: 650;
        }

        .student-status-pill {
            min-height: 46px;
            border-radius: 999px;
            padding: 0 18px;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            white-space: nowrap;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
            font-size: 14px;
            font-weight: 950;
        }

        .student-status-pill.public {
            background: #dcfce7;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .student-status-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: currentColor;
        }

        .student-stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .student-stat {
            position: relative;
            overflow: hidden;
            min-height: 104px;
            border-radius: 24px;
            border: 1px solid #dbe7f5;
            background: #f8fbff;
            padding: 18px;
            box-sizing: border-box;
        }

        .student-stat::after {
            content: "";
            position: absolute;
            right: -30px;
            top: -30px;
            width: 84px;
            height: 84px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.08);
        }

        .student-stat span {
            position: relative;
            z-index: 2;
            display: block;
            color: #52647d;
            font-size: 13px;
            font-weight: 950;
        }

        .student-stat strong {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 8px;
            color: #07152f;
            font-size: 38px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.07em;
        }

        .student-stat.success {
            background: linear-gradient(145deg, #f0fdf4, #ffffff);
            border-color: #bbf7d0;
        }

        .student-stat.success strong {
            color: #16a34a;
        }

        .student-stat.warning {
            background: linear-gradient(145deg, #fffbeb, #ffffff);
            border-color: #fde68a;
        }

        .student-stat.warning strong {
            color: #d97706;
        }

        .student-stat.danger {
            background: linear-gradient(145deg, #fff1f2, #ffffff);
            border-color: #fecdd3;
        }

        .student-stat.danger strong {
            color: #e11d48;
        }

        .student-stat.primary {
            background: linear-gradient(145deg, #eff6ff, #ffffff);
            border-color: #bfdbfe;
        }

        .student-stat.primary strong {
            color: #2563eb;
        }

        .student-content-grid {
            display: grid;
            grid-template-columns: 1.25fr 0.9fr;
            gap: 22px;
            margin-bottom: 24px;
        }

        .student-panel {
            border: 1px solid #dbe7f5;
            border-radius: 30px;
            background: #ffffff;
            padding: 24px;
            box-sizing: border-box;
            box-shadow: 0 16px 38px rgba(15, 23, 42, 0.06);
        }

        .student-panel-title {
            margin: 0;
            color: #07152f;
            font-size: 18px;
            line-height: 1.3;
            font-weight: 950;
            letter-spacing: -0.035em;
        }

        .student-panel-sub {
            margin: 7px 0 0;
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
            font-weight: 650;
        }

        .student-chart {
            min-height: 220px;
            display: flex;
            align-items: end;
            gap: 15px;
            padding: 30px 6px 0;
            box-sizing: border-box;
        }

        .student-chart-column {
            flex: 1;
            min-width: 38px;
            display: grid;
            align-items: end;
            gap: 10px;
            text-align: center;
        }

        .student-chart-bar-wrap {
            height: 150px;
            display: flex;
            align-items: end;
            justify-content: center;
            border-radius: 18px;
            background: linear-gradient(180deg, #f8fbff, #eef6ff);
            border: 1px solid #edf2fb;
            padding: 8px;
            box-sizing: border-box;
        }

        .student-chart-bar {
            width: 100%;
            border-radius: 13px 13px 8px 8px;
            background: linear-gradient(180deg, #78adff 0%, #2563eb 100%);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.20);
        }

        .student-chart-total {
            color: #07152f;
            font-size: 14px;
            line-height: 1;
            font-weight: 950;
        }

        .student-chart-label {
            color: #64748b;
            font-size: 12px;
            line-height: 1;
            font-weight: 900;
        }

        .student-distribution {
            display: grid;
            gap: 14px;
            margin-top: 18px;
        }

        .distribution-item {
            display: grid;
            grid-template-columns: 105px 1fr 34px;
            gap: 12px;
            align-items: center;
        }

        .distribution-label {
            color: #334155;
            font-size: 13px;
            font-weight: 950;
        }

        .distribution-total {
            color: #07152f;
            font-size: 14px;
            font-weight: 950;
            text-align: right;
        }

        .distribution-track {
            height: 12px;
            border-radius: 999px;
            background: #eef2f7;
            overflow: hidden;
        }

        .distribution-fill {
            height: 100%;
            border-radius: 999px;
            min-width: 4px;
        }

        .distribution-fill.submitted {
            background: linear-gradient(90deg, #fbbf24, #d97706);
        }

        .distribution-fill.review {
            background: linear-gradient(90deg, #60a5fa, #2563eb);
        }

        .distribution-fill.approved {
            background: linear-gradient(90deg, #4ade80, #16a34a);
        }

        .distribution-fill.rejected {
            background: linear-gradient(90deg, #fb7185, #e11d48);
        }

        .distribution-fill.campus {
            background: linear-gradient(90deg, #93c5fd, #2563eb);
        }

        .distribution-fill.regional {
            background: linear-gradient(90deg, #67e8f9, #0891b2);
        }

        .distribution-fill.national {
            background: linear-gradient(90deg, #86efac, #16a34a);
        }

        .distribution-fill.international {
            background: linear-gradient(90deg, #c4b5fd, #7c3aed);
        }

        .student-status-list {
            display: grid;
            gap: 0;
            margin-top: 14px;
        }

        .student-status-item {
            padding: 14px 0;
            border-bottom: 1px solid #e7eef8;
        }

        .student-status-item:last-child {
            border-bottom: 0;
        }

        .student-status-item h3 {
            margin: 0;
            color: #07152f;
            font-size: 15px;
            line-height: 1.45;
            font-weight: 950;
        }

        .student-status-item p {
            margin: 6px 0 0;
            font-size: 13px;
            line-height: 1.45;
            font-weight: 850;
        }

        .status-text-submitted {
            color: #d97706;
        }

        .status-text-review {
            color: #2563eb;
        }

        .status-text-approved {
            color: #16a34a;
        }

        .status-text-rejected {
            color: #e11d48;
        }

        .student-action-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .student-action-card {
            min-height: 118px;
            border-radius: 24px;
            border: 1px solid #dbe7f5;
            background: #f8fbff;
            padding: 18px;
            display: grid;
            align-content: space-between;
            color: #07152f;
            text-decoration: none;
            transition: 0.18s ease;
            box-sizing: border-box;
        }

        .student-action-card:hover {
            transform: translateY(-2px);
            border-color: #bfdbfe;
            background: #eff6ff;
            box-shadow: 0 16px 34px rgba(37, 99, 235, 0.10);
        }

        .student-action-card strong {
            display: block;
            font-size: 16px;
            line-height: 1.35;
            font-weight: 950;
        }

        .student-action-card span {
            display: block;
            margin-top: 6px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .student-action-icon {
            width: 42px;
            height: 42px;
            border-radius: 16px;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 950;
        }

        .student-recent-list {
            display: grid;
            gap: 12px;
            margin-top: 16px;
        }

        .student-recent-card {
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            background: #f8fbff;
            padding: 16px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 14px;
            align-items: center;
        }

        .student-recent-card h3 {
            margin: 0;
            color: #07152f;
            font-size: 16px;
            line-height: 1.4;
            font-weight: 950;
        }

        .student-recent-card p {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
            font-weight: 700;
        }

        .student-badge {
            min-height: 32px;
            border-radius: 999px;
            padding: 0 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            font-size: 12px;
            font-weight: 950;
            border: 1px solid transparent;
        }

        .badge-submitted {
            color: #92400e;
            background: #fef3c7;
            border-color: #fde68a;
        }

        .badge-review {
            color: #1d4ed8;
            background: #dbeafe;
            border-color: #bfdbfe;
        }

        .badge-approved {
            color: #15803d;
            background: #dcfce7;
            border-color: #bbf7d0;
        }

        .badge-rejected {
            color: #b91c1c;
            background: #fee2e2;
            border-color: #fecaca;
        }

        .badge-gray {
            color: #475569;
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        .student-empty {
            margin-top: 16px;
            border: 1px dashed #cbd5e1;
            border-radius: 22px;
            background: #f8fbff;
            padding: 24px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            font-weight: 700;
        }

        @media (max-width: 1120px) {
            .student-dashboard-shell {
                grid-template-columns: 1fr;
            }

            .student-dashboard-side {
                border-right: 0;
                border-bottom: 1px solid #dbe7f5;
            }

            .student-menu {
                grid-template-columns: repeat(4, 1fr);
            }

            .student-dashboard-header,
            .student-content-grid,
            .student-action-row {
                grid-template-columns: 1fr;
            }

            .student-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 720px) {
            .student-dashboard-page {
                padding: 22px 14px 34px;
            }

            .student-dashboard-shell {
                border-radius: 30px;
            }

            .student-dashboard-side,
            .student-dashboard-main {
                padding: 26px 20px;
            }

            .student-menu {
                grid-template-columns: 1fr;
            }

            .student-stats {
                grid-template-columns: 1fr;
            }

            .student-recent-card {
                grid-template-columns: 1fr;
            }

            .student-greeting {
                font-size: 30px;
            }

            .distribution-item {
                grid-template-columns: 92px 1fr 28px;
            }

            .student-chart {
                gap: 8px;
            }
        }
    </style>

    <main class="student-dashboard-page">
        <div class="student-dashboard-wrap">
            <section class="student-dashboard-shell">
                <aside class="student-dashboard-side">
                    <div class="student-profile-box">
                        <div class="student-avatar">
                            @if ($foto)
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto {{ $nama }}">
                            @else
                                {{ $initial }}
                            @endif
                        </div>

                        <h2 class="student-name">
                            {{ $nama }}
                        </h2>

                        <p class="student-major">
                            {{ $profilMahasiswa?->program_studi ?: 'Program Studi belum diisi' }}
                            <br>
                            {{ $profilMahasiswa?->fakultas ?: 'Fakultas belum diisi' }}
                        </p>
                    </div>

                    <nav class="student-menu">
                        <a href="{{ $dashboardRoute }}" class="student-menu-link active">
                            <span class="student-menu-icon">⌂</span>
                            Dashboard
                        </a>

                        <a href="{{ $profilRoute }}" class="student-menu-link">
                            <span class="student-menu-icon">👤</span>
                            Profil Saya
                        </a>

                        <a href="{{ $createPrestasiRoute }}" class="student-menu-link">
                            <span class="student-menu-icon">＋</span>
                            Pengajuan Prestasi
                        </a>

                        <a href="{{ $prestasiRoute }}" class="student-menu-link">
                            <span class="student-menu-icon">🏆</span>
                            Prestasi Saya
                        </a>

                        <a href="{{ $publicShowRoute ?: $publicIndexRoute }}" target="_blank" class="student-menu-link">
                            <span class="student-menu-icon">🌐</span>
                            Portofolio Public
                        </a>
                    </nav>
                </aside>

                <section class="student-dashboard-main">
                    @if (session('success'))
                        <div style="margin-bottom: 20px; border-radius: 18px; padding: 15px 18px; background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; font-size: 14px; font-weight: 900;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div style="margin-bottom: 20px; border-radius: 18px; padding: 15px 18px; background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; font-size: 14px; font-weight: 900;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="student-dashboard-header">
                        <div>
                            <h1 class="student-greeting">
                                Halo, {{ $nama }}
                            </h1>

                            <p class="student-greeting-sub">
                                Statistik di halaman ini dihitung langsung dari data prestasi kamu: status pengajuan, tingkat prestasi, dan aktivitas per bulan.
                            </p>
                        </div>

                        <div class="student-status-pill {{ $isPublic ? 'public' : '' }}">
                            <span class="student-status-dot"></span>
                            {{ $isPublic ? 'Public Aktif' : 'Public Nonaktif' }}
                        </div>
                    </div>

                    <div class="student-stats">
                        <article class="student-stat primary">
                            <span>Total Prestasi</span>
                            <strong>{{ $totalPrestasi }}</strong>
                        </article>

                        <article class="student-stat warning">
                            <span>Dalam Proses</span>
                            <strong>{{ $totalMenunggu }}</strong>
                        </article>

                        <article class="student-stat success">
                            <span>Disetujui</span>
                            <strong>{{ $totalDisetujui }}</strong>
                        </article>

                        <article class="student-stat primary">
                            <span>Tampil Public</span>
                            <strong>{{ $totalPublic }}</strong>
                        </article>

                        <article class="student-stat danger">
                            <span>Ditolak</span>
                            <strong>{{ $totalDitolak }}</strong>
                        </article>
                    </div>

                    <div class="student-content-grid">
                        <article class="student-panel">
                            <h2 class="student-panel-title">
                                Statistik Prestasi per Bulan
                            </h2>

                            <p class="student-panel-sub">
                                Grafik ini mengikuti jumlah prestasi berdasarkan tanggal prestasi dalam 6 bulan terakhir.
                            </p>

                            <div class="student-chart">
                                @foreach ($monthlyChart as $item)
                                    <div class="student-chart-column">
                                        <div class="student-chart-total">
                                            {{ $item['total'] }}
                                        </div>

                                        <div class="student-chart-bar-wrap">
                                            <div class="student-chart-bar" style="height: {{ $item['height'] }}%;"></div>
                                        </div>

                                        <div class="student-chart-label">
                                            {{ $item['label'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>

                        <article class="student-panel">
                            <h2 class="student-panel-title">
                                Distribusi Status
                            </h2>

                            <p class="student-panel-sub">
                                Persentase status berdasarkan semua prestasi milik kamu.
                            </p>

                            <div class="student-distribution">
                                @foreach ($statusChart as $status)
                                    @php
                                        $percentage = $status['total'] > 0
                                            ? max(4, round(($status['total'] / $totalForStatus) * 100))
                                            : 0;
                                    @endphp

                                    <div class="distribution-item">
                                        <div class="distribution-label">
                                            {{ $status['label'] }}
                                        </div>

                                        <div class="distribution-track">
                                            <div class="distribution-fill {{ $status['class'] }}" style="width: {{ $percentage }}%;"></div>
                                        </div>

                                        <div class="distribution-total">
                                            {{ $status['total'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    </div>

                    <div class="student-content-grid">
                        <article class="student-panel">
                            <h2 class="student-panel-title">
                                Tingkat Prestasi
                            </h2>

                            <p class="student-panel-sub">
                                Pembagian prestasi berdasarkan tingkat kompetisi atau kegiatan.
                            </p>

                            <div class="student-distribution">
                                @foreach ($tingkatChart as $tingkat)
                                    @php
                                        $percentage = $tingkat['total'] > 0
                                            ? max(4, round(($tingkat['total'] / $totalForTingkat) * 100))
                                            : 0;
                                    @endphp

                                    <div class="distribution-item">
                                        <div class="distribution-label">
                                            {{ $tingkat['label'] }}
                                        </div>

                                        <div class="distribution-track">
                                            <div class="distribution-fill {{ $tingkat['class'] }}" style="width: {{ $percentage }}%;"></div>
                                        </div>

                                        <div class="distribution-total">
                                            {{ $tingkat['total'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>

                        <article class="student-panel">
                            <h2 class="student-panel-title">
                                Status Terbaru
                            </h2>

                            <p class="student-panel-sub">
                                Update pengajuan terakhir.
                            </p>

                            @if ($prestasisTerbaru->isEmpty())
                                <div class="student-empty">
                                    Belum ada pengajuan prestasi.
                                </div>
                            @else
                                <div class="student-status-list">
                                    @foreach ($prestasisTerbaru->take(3) as $prestasi)
                                        @php
                                            $statusClass = match ($prestasi->status) {
                                                'submitted' => 'status-text-submitted',
                                                'under_review' => 'status-text-review',
                                                'approved', 'published' => 'status-text-approved',
                                                'rejected' => 'status-text-rejected',
                                                default => 'status-text-submitted',
                                            };

                                            $statusLabel = match ($prestasi->status) {
                                                'submitted' => 'Menunggu Validasi',
                                                'under_review' => 'Sedang Direview',
                                                'approved' => 'Tervalidasi',
                                                'published' => 'Tampil Public',
                                                'rejected' => 'Ditolak',
                                                default => ucfirst((string) $prestasi->status),
                                            };
                                        @endphp

                                        <div class="student-status-item">
                                            <h3>
                                                {{ $prestasi->judul }}
                                            </h3>

                                            <p class="{{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </article>
                    </div>

                    <div class="student-action-row">
                        <a href="{{ $profilRoute }}" class="student-action-card">
                            <div class="student-action-icon">👤</div>

                            <div>
                                <strong>Lengkapi Profil</strong>
                                <span>{{ $profileComplete ? 'Profil kamu sudah lengkap.' : 'Lengkapi data diri agar portofolio lebih profesional.' }}</span>
                            </div>
                        </a>

                        <a href="{{ $createPrestasiRoute }}" class="student-action-card">
                            <div class="student-action-icon">＋</div>

                            <div>
                                <strong>Ajukan Prestasi</strong>
                                <span>Upload data prestasi dan file bukti untuk divalidasi admin.</span>
                            </div>
                        </a>

                        <a href="{{ $publicShowRoute ?: $publicIndexRoute }}" target="_blank" class="student-action-card">
                            <div class="student-action-icon">🌐</div>

                            <div>
                                <strong>Lihat Public</strong>
                                <span>Preview halaman portofolio public kamu.</span>
                            </div>
                        </a>
                    </div>

                    <article class="student-panel">
                        <h2 class="student-panel-title">
                            Prestasi Terbaru
                        </h2>

                        <p class="student-panel-sub">
                            Daftar pengajuan terbaru yang sudah kamu input.
                        </p>

                        @if ($prestasisTerbaru->isEmpty())
                            <div class="student-empty">
                                Belum ada prestasi. Klik menu Pengajuan Prestasi untuk mulai menambahkan data.
                            </div>
                        @else
                            <div class="student-recent-list">
                                @foreach ($prestasisTerbaru as $prestasi)
                                    @php
                                        $badgeClass = match ($prestasi->status) {
                                            'submitted' => 'badge-submitted',
                                            'under_review' => 'badge-review',
                                            'approved', 'published' => 'badge-approved',
                                            'rejected' => 'badge-rejected',
                                            default => 'badge-gray',
                                        };

                                        $badgeLabel = match ($prestasi->status) {
                                            'submitted' => 'Submitted',
                                            'under_review' => 'Under Review',
                                            'approved' => 'Approved',
                                            'published' => 'Published',
                                            'rejected' => 'Rejected',
                                            default => ucfirst((string) $prestasi->status),
                                        };

                                        $tanggal = $prestasi->tanggal_prestasi
                                            ? Carbon::parse($prestasi->tanggal_prestasi)->format('d M Y')
                                            : '-';
                                    @endphp

                                    <div class="student-recent-card">
                                        <div>
                                            <h3>
                                                {{ $prestasi->judul }}
                                            </h3>

                                            <p>
                                                {{ $prestasi->kategoriPrestasi->nama ?? 'Tanpa Kategori' }}
                                                ·
                                                {{ ucfirst((string) $prestasi->tingkat) }}
                                                ·
                                                {{ $tanggal }}
                                                ·
                                                {{ $prestasi->filePrestasis->count() }} file
                                            </p>
                                        </div>

                                        <span class="student-badge {{ $badgeClass }}">
                                            {{ $badgeLabel }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </article>
                </section>
            </section>
        </div>
    </main>
</div>