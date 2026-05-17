<div>
    <style>
        .public-hero-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 34px;
            align-items: center;
        }

        .public-hero-card {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 30px;
            padding: 20px;
            box-shadow: var(--ep-shadow-lg);
            backdrop-filter: blur(18px);
        }

        .public-hero-inner-card {
            background: #ffffff;
            color: var(--ep-text);
            border-radius: 24px;
            padding: 22px;
        }

        .public-profile-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 22px;
            align-items: stretch;
        }

        .public-profile-main {
            display: grid;
            grid-template-columns: 108px 1fr;
            gap: 22px;
            align-items: flex-start;
        }

        .public-avatar {
            width: 108px;
            height: 108px;
            border-radius: 30px;
            overflow: hidden;
            background: linear-gradient(135deg, #020617, #173b7a);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 46px;
            font-weight: 900;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.20);
        }

        .public-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .public-name {
            margin: 9px 0 0;
            color: var(--ep-text);
            font-size: 34px;
            line-height: 1.08;
            font-weight: 900;
            letter-spacing: -0.055em;
        }

        .public-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px 20px;
            margin-top: 22px;
        }

        .public-meta {
            padding: 14px;
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid var(--ep-border);
        }

        .public-meta span {
            display: block;
            color: var(--ep-muted);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .public-meta strong {
            display: block;
            margin-top: 4px;
            color: var(--ep-text);
            font-size: 14px;
            font-weight: 900;
            line-height: 1.45;
        }

        .public-bio {
            grid-column: 1 / -1;
            padding: 16px;
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid var(--ep-border);
            color: #334155;
            line-height: 1.75;
        }

        .public-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 22px;
        }

        .public-stat {
            position: relative;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--ep-border);
            border-radius: 26px;
            padding: 22px;
            box-shadow: var(--ep-shadow-sm);
        }

        .public-stat::after {
            content: "";
            position: absolute;
            right: -28px;
            top: -28px;
            width: 82px;
            height: 82px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.08);
        }

        .public-stat span {
            display: block;
            color: var(--ep-muted);
            font-size: 13px;
            font-weight: 900;
        }

        .public-stat strong {
            display: block;
            margin-top: 8px;
            color: var(--ep-text);
            font-size: 38px;
            line-height: 1;
            font-weight: 900;
            letter-spacing: -0.06em;
        }

        .achievement-section-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin: 36px 0 18px;
        }

        .achievement-section-head h2 {
            margin: 0;
            color: var(--ep-text);
            font-size: 30px;
            line-height: 1.12;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .achievement-section-head p {
            margin: 8px 0 0;
            color: var(--ep-muted);
        }

        .achievement-list {
            display: grid;
            gap: 18px;
        }

        .achievement-card {
            display: grid;
            grid-template-columns: 110px 1fr;
            gap: 22px;
            background: #ffffff;
            border: 1px solid var(--ep-border);
            border-radius: 30px;
            padding: 24px;
            box-shadow: var(--ep-shadow-sm);
        }

        .achievement-icon {
            width: 100%;
            min-height: 110px;
            border-radius: 26px;
            background:
                radial-gradient(circle at 75% 18%, rgba(22, 163, 74, 0.16), transparent 34px),
                linear-gradient(145deg, #eff6ff, #ffffff);
            border: 1px solid #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 44px;
        }

        .achievement-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .achievement-title {
            margin: 12px 0 0;
            color: var(--ep-text);
            font-size: 24px;
            line-height: 1.28;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .achievement-info-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .achievement-info {
            padding: 13px;
            border-radius: 17px;
            background: #f8fbff;
            border: 1px solid var(--ep-border);
        }

        .achievement-info span {
            display: block;
            color: var(--ep-muted);
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .achievement-info strong {
            display: block;
            margin-top: 4px;
            color: var(--ep-text);
            font-size: 13px;
            line-height: 1.45;
            font-weight: 900;
        }

        .achievement-desc {
            margin: 16px 0 0;
            color: #334155;
            line-height: 1.75;
        }

        .achievement-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .empty-achievement {
            text-align: center;
            padding: 42px 28px;
            border: 1px dashed #cbd5e1;
            border-radius: 30px;
            background: #ffffff;
            box-shadow: var(--ep-shadow-sm);
        }

        .empty-achievement h2 {
            margin: 0;
            color: var(--ep-text);
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .empty-achievement p {
            max-width: 560px;
            margin: 10px auto 0;
            color: var(--ep-muted);
            line-height: 1.8;
        }

        @media (max-width: 1050px) {
            .public-hero-grid,
            .public-profile-grid,
            .public-stats {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .public-profile-main,
            .public-meta-grid,
            .achievement-card,
            .achievement-info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $nama = $portofolio->name ?? 'Mahasiswa';
        $initial = strtoupper(substr($nama, 0, 1));
    @endphp

    <main>
        <section class="ep-hero">
            <div class="ep-hero-pattern"></div>

            <div class="ep-container">
                <div class="ep-hero-inner">
                    <div class="public-hero-grid">
                        <div>
                            <p class="ep-eyebrow">
                                E-Portfolio Prestasi Mahasiswa
                            </p>

                            <h1 class="ep-title">
                                {{ $nama }}
                            </h1>

                            <p class="ep-subtitle">
                                Halaman portofolio public untuk menampilkan profil mahasiswa dan prestasi yang telah divalidasi admin.
                            </p>

                            <div class="ep-actions">
                                <a href="{{ route('portofolio.index') }}" class="ep-btn ep-btn-white">
                                    Kembali ke Direktori
                                </a>

                                <button type="button" onclick="window.print()" class="ep-btn ep-btn-ghost no-print">
                                    Cetak Portofolio
                                </button>
                            </div>
                        </div>

                        <aside class="public-hero-card">
                            <div class="public-hero-inner-card">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <div class="public-avatar" style="width: 70px; height: 70px; border-radius: 24px; font-size: 30px;">
                                        @if ($portofolio->foto)
                                            <img src="{{ asset('storage/' . $portofolio->foto) }}" alt="Foto {{ $nama }}">
                                        @else
                                            {{ $initial }}
                                        @endif
                                    </div>

                                    <div>
                                        <h2 style="margin: 0; color: var(--ep-text); font-size: 22px; line-height: 1.15; font-weight: 900; letter-spacing: -0.04em;">
                                            {{ $totalPrestasi }} Prestasi
                                        </h2>

                                        <p style="margin: 5px 0 0; color: var(--ep-muted); font-size: 13px;">
                                            Sudah divalidasi dan tampil public.
                                        </p>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 20px;">
                                    <div style="border: 1px solid var(--ep-border); border-radius: 17px; padding: 13px;">
                                        <span style="display: block; color: var(--ep-muted); font-size: 11px; font-weight: 900;">Nasional</span>
                                        <strong style="display: block; margin-top: 4px; font-size: 28px; line-height: 1; font-weight: 900;">{{ $totalNasional }}</strong>
                                    </div>

                                    <div style="border: 1px solid var(--ep-border); border-radius: 17px; padding: 13px;">
                                        <span style="display: block; color: var(--ep-muted); font-size: 11px; font-weight: 900;">Internas.</span>
                                        <strong style="display: block; margin-top: 4px; color: var(--ep-primary); font-size: 28px; line-height: 1; font-weight: 900;">{{ $totalInternasional }}</strong>
                                    </div>

                                    <div style="border: 1px solid var(--ep-border); border-radius: 17px; padding: 13px;">
                                        <span style="display: block; color: var(--ep-muted); font-size: 11px; font-weight: 900;">Lainnya</span>
                                        <strong style="display: block; margin-top: 4px; color: var(--ep-success); font-size: 28px; line-height: 1; font-weight: 900;">{{ $totalKampusRegional }}</strong>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>

        <section class="ep-section">
            <div class="ep-container">
                <div class="public-profile-grid">
                    <article class="ep-card ep-card-pad">
                        <div class="public-profile-main">
                            <div class="public-avatar">
                                @if ($portofolio->foto)
                                    <img src="{{ asset('storage/' . $portofolio->foto) }}" alt="Foto {{ $nama }}">
                                @else
                                    {{ $initial }}
                                @endif
                            </div>

                            <div>
                                <p class="ep-eyebrow" style="color: var(--ep-primary); background: var(--ep-primary-soft); border-color: var(--ep-primary-soft);">
                                    Profil Mahasiswa
                                </p>

                                <h2 class="public-name">
                                    {{ $nama }}
                                </h2>

                                <div class="public-meta-grid">
                                    <div class="public-meta">
                                        <span>NIM</span>
                                        <strong>{{ $portofolio->nim ?: '-' }}</strong>
                                    </div>

                                    <div class="public-meta">
                                        <span>Program Studi</span>
                                        <strong>{{ $portofolio->program_studi ?: '-' }}</strong>
                                    </div>

                                    <div class="public-meta">
                                        <span>Fakultas</span>
                                        <strong>{{ $portofolio->fakultas ?: '-' }}</strong>
                                    </div>

                                    <div class="public-meta">
                                        <span>Angkatan</span>
                                        <strong>{{ $portofolio->angkatan ?: '-' }}</strong>
                                    </div>

                                    <div class="public-bio">
                                        <strong>Bio:</strong>
                                        {{ $portofolio->bio ?: 'Mahasiswa ini belum menambahkan bio pada portofolio public.' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <aside class="ep-card ep-card-pad">
                        <p class="ep-eyebrow" style="color: var(--ep-primary); background: var(--ep-primary-soft); border-color: var(--ep-primary-soft);">
                            Ringkasan
                        </p>

                        <h2 style="margin: 12px 0 0; color: var(--ep-text); font-size: 34px; line-height: 1.1; font-weight: 900; letter-spacing: -0.055em;">
                            {{ $totalPrestasi }} Prestasi
                        </h2>

                        <p style="margin: 12px 0 0; color: var(--ep-muted); line-height: 1.8;">
                            Semua prestasi yang tampil pada halaman ini telah melewati proses validasi admin.
                        </p>

                        <div style="margin-top: 18px;">
                            <span class="ep-badge ep-badge-green">
                                Public Aktif
                            </span>
                        </div>
                    </aside>
                </div>

                <div class="public-stats">
                    <article class="public-stat">
                        <span>Total Prestasi</span>
                        <strong>{{ $totalPrestasi }}</strong>
                    </article>

                    <article class="public-stat">
                        <span>Nasional</span>
                        <strong>{{ $totalNasional }}</strong>
                    </article>

                    <article class="public-stat">
                        <span>Internasional</span>
                        <strong>{{ $totalInternasional }}</strong>
                    </article>

                    <article class="public-stat">
                        <span>Status</span>
                        <strong style="font-size: 26px; letter-spacing: -0.04em;">Public</strong>
                    </article>
                </div>

                <div class="achievement-section-head">
                    <div>
                        <h2>Prestasi Tervalidasi</h2>
                        <p>Daftar prestasi yang sudah disetujui admin dan ditampilkan pada portofolio public.</p>
                    </div>
                </div>

                @if ($prestasis->isEmpty())
                    <div class="empty-achievement">
                        <h2>Belum Ada Prestasi Public</h2>

                        <p>
                            Mahasiswa ini belum memiliki prestasi yang disetujui dan ditampilkan pada halaman public.
                        </p>
                    </div>
                @else
                    <div class="achievement-list">
                        @foreach ($prestasis as $prestasi)
                            @php
                                $tanggalPrestasi = $prestasi->tanggal_prestasi
                                    ? \Illuminate\Support\Carbon::parse($prestasi->tanggal_prestasi)->format('d M Y')
                                    : '-';

                                $files = $filesByPrestasi->get($prestasi->id, collect());
                                $firstFile = $files->first();

                                $filePath = $firstFile
                                    ? (data_get($firstFile, 'path_file') ?? data_get($firstFile, 'file_path') ?? data_get($firstFile, 'path'))
                                    : null;
                            @endphp

                            <article class="achievement-card">
                                <div class="achievement-icon">
                                    🏆
                                </div>

                                <div>
                                    <div class="achievement-badges">
                                        <span class="ep-badge ep-badge-blue">
                                            {{ $prestasi->kategori_nama ?: 'Prestasi' }}
                                        </span>

                                        <span class="ep-badge ep-badge-purple">
                                            {{ ucfirst((string) $prestasi->tingkat) }}
                                        </span>

                                        <span class="ep-badge ep-badge-green">
                                            Tervalidasi
                                        </span>
                                    </div>

                                    <h3 class="achievement-title">
                                        {{ $prestasi->judul }}
                                    </h3>

                                    <div class="achievement-info-grid">
                                        <div class="achievement-info">
                                            <span>Penyelenggara</span>
                                            <strong>{{ $prestasi->penyelenggara ?: '-' }}</strong>
                                        </div>

                                        <div class="achievement-info">
                                            <span>Jenis</span>
                                            <strong>{{ $prestasi->jenis_prestasi ?: '-' }}</strong>
                                        </div>

                                        <div class="achievement-info">
                                            <span>Tanggal</span>
                                            <strong>{{ $tanggalPrestasi }}</strong>
                                        </div>

                                        <div class="achievement-info">
                                            <span>File Bukti</span>
                                            <strong>{{ $files->count() }} file</strong>
                                        </div>
                                    </div>

                                    @if ($prestasi->deskripsi)
                                        <p class="achievement-desc">
                                            {{ $prestasi->deskripsi }}
                                        </p>
                                    @endif

                                    @if ($filePath)
                                        <div class="achievement-actions no-print">
                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="ep-btn ep-btn-white">
                                                Lihat Bukti
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
</div>