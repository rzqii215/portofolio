<div>
    <style>
        .prestasi-toolbar {
            display: grid;
            grid-template-columns: 1fr 190px 190px auto;
            gap: 14px;
            align-items: end;
        }

        .prestasi-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 22px;
            align-items: start;
            margin-top: 22px;
        }

        .prestasi-list {
            display: grid;
            gap: 18px;
        }

        .prestasi-card {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 22px;
            background: #ffffff;
            border: 1px solid var(--ep-border);
            border-radius: 30px;
            padding: 24px;
            box-shadow: var(--ep-shadow-sm);
        }

        .prestasi-icon {
            width: 100%;
            min-height: 120px;
            border-radius: 26px;
            background:
                radial-gradient(circle at 75% 18%, rgba(22, 163, 74, 0.16), transparent 34px),
                linear-gradient(145deg, #eff6ff, #ffffff);
            border: 1px solid #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 46px;
        }

        .prestasi-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
        }

        .prestasi-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .prestasi-title {
            margin: 12px 0 0;
            color: var(--ep-text);
            font-size: 24px;
            line-height: 1.28;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .prestasi-info-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .prestasi-info {
            padding: 13px;
            border-radius: 17px;
            background: #f8fbff;
            border: 1px solid var(--ep-border);
        }

        .prestasi-info span {
            display: block;
            color: var(--ep-muted);
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .prestasi-info strong {
            display: block;
            margin-top: 4px;
            color: var(--ep-text);
            font-size: 13px;
            line-height: 1.45;
            font-weight: 900;
        }

        .prestasi-desc {
            margin: 16px 0 0;
            color: #334155;
            line-height: 1.75;
        }

        .prestasi-status-box {
            display: grid;
            grid-template-columns: 42px 1fr auto;
            gap: 14px;
            align-items: center;
            margin-top: 18px;
            padding: 16px;
            border-radius: 20px;
        }

        .prestasi-status-box h4 {
            margin: 0;
            font-size: 15px;
            color: inherit;
            font-weight: 900;
        }

        .prestasi-status-box p {
            margin: 4px 0 0;
            color: inherit;
            opacity: 0.9;
            font-size: 13px;
            line-height: 1.6;
        }

        .status-submitted {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .status-review {
            background: #dbeafe;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .status-approved {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .status-rejected {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .prestasi-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
            margin-top: 18px;
        }

        .prestasi-summary {
            position: sticky;
            top: 98px;
            display: grid;
            gap: 14px;
        }

        .summary-row {
            display: grid;
            grid-template-columns: 46px 1fr auto;
            gap: 12px;
            align-items: center;
            padding: 14px;
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid var(--ep-border);
        }

        .summary-row strong {
            display: block;
            color: var(--ep-text);
            font-size: 14px;
            font-weight: 900;
        }

        .summary-row span {
            display: block;
            color: var(--ep-muted);
            font-size: 12px;
            margin-top: 2px;
        }

        .empty-prestasi {
            text-align: center;
            padding: 42px 28px;
            border: 1px dashed #cbd5e1;
            border-radius: 30px;
            background: #ffffff;
            box-shadow: var(--ep-shadow-sm);
        }

        .empty-prestasi h2 {
            margin: 0;
            color: var(--ep-text);
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .empty-prestasi p {
            max-width: 560px;
            margin: 10px auto 0;
            color: var(--ep-muted);
            line-height: 1.8;
        }

        @media (max-width: 1050px) {
            .prestasi-layout,
            .prestasi-toolbar {
                grid-template-columns: 1fr;
            }

            .prestasi-summary {
                position: static;
            }
        }

        @media (max-width: 760px) {
            .prestasi-card,
            .prestasi-status-box {
                grid-template-columns: 1fr;
            }

            .prestasi-info-grid {
                grid-template-columns: 1fr;
            }

            .prestasi-actions,
            .prestasi-actions .ep-btn {
                width: 100%;
            }
        }
    </style>

    <main>
        <section class="ep-hero">
            <div class="ep-hero-pattern"></div>

            <div class="ep-container">
                <div class="ep-hero-inner">
                    <p class="ep-eyebrow">
                        Prestasi Saya
                    </p>

                    <h1 class="ep-title">
                        Pantau Pengajuan <span>Prestasi</span>
                    </h1>

                    <p class="ep-subtitle">
                        Kelola daftar prestasi yang sudah diajukan. Data yang sudah terkirim kepada admin akan otomatis terkunci dari edit dan hapus.
                    </p>

                    <div class="ep-actions">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="ep-btn ep-btn-white">
                            Dashboard
                        </a>

                        <a href="{{ route('mahasiswa.prestasi.create') }}" class="ep-btn ep-btn-primary">
                            Tambah Prestasi
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="ep-section">
            <div class="ep-container">
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

                <div class="ep-card ep-card-pad">
                    <div class="prestasi-toolbar">
                        <div>
                            <label class="ep-form-label">
                                Cari Prestasi
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.500ms="search"
                                placeholder="Cari judul, penyelenggara, jenis, atau deskripsi"
                            >
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Status
                            </label>

                            <select wire:model.live="status">
                                <option value="">Semua Status</option>
                                <option value="submitted">Submitted</option>
                                <option value="under_review">Under Review</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="published">Published</option>
                            </select>
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Tingkat
                            </label>

                            <select wire:model.live="tingkat">
                                <option value="">Semua Tingkat</option>
                                <option value="kampus">Kampus</option>
                                <option value="regional">Regional</option>
                                <option value="nasional">Nasional</option>
                                <option value="internasional">Internasional</option>
                            </select>
                        </div>

                        <button type="button" wire:click="resetFilter" class="ep-btn ep-btn-dark">
                            Reset
                        </button>
                    </div>
                </div>

                <div class="prestasi-layout">
                    <section>
                        @if ($prestasis->isEmpty())
                            <div class="empty-prestasi">
                                <h2>
                                    Belum Ada Prestasi
                                </h2>

                                <p>
                                    Tambahkan prestasi pertama kamu untuk dikirim ke admin. Setelah diajukan, admin akan memvalidasi data dan file bukti.
                                </p>

                                <div style="margin-top: 22px;">
                                    <a href="{{ route('mahasiswa.prestasi.create') }}" class="ep-btn ep-btn-primary">
                                        Tambah Prestasi Pertama
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="prestasi-list">
                                @foreach ($prestasis as $prestasi)
                                    @php
                                        $statusColor = match ($prestasi->status) {
                                            'submitted' => 'ep-badge-yellow',
                                            'under_review' => 'ep-badge-blue',
                                            'approved', 'published' => 'ep-badge-green',
                                            'rejected' => 'ep-badge-red',
                                            default => 'ep-badge-gray',
                                        };

                                        $statusLabel = match ($prestasi->status) {
                                            'submitted' => 'Submitted',
                                            'under_review' => 'Under Review',
                                            'approved' => 'Approved',
                                            'published' => 'Published',
                                            'rejected' => 'Rejected',
                                            default => ucfirst((string) $prestasi->status),
                                        };

                                        $statusBoxClass = match ($prestasi->status) {
                                            'submitted' => 'status-submitted',
                                            'under_review' => 'status-review',
                                            'approved', 'published' => 'status-approved',
                                            'rejected' => 'status-rejected',
                                            default => 'status-submitted',
                                        };

                                        $statusIcon = match ($prestasi->status) {
                                            'submitted' => '⏳',
                                            'under_review' => '🔎',
                                            'approved', 'published' => '✓',
                                            'rejected' => '!',
                                            default => '⏳',
                                        };

                                        $statusTitle = match ($prestasi->status) {
                                            'submitted' => 'Menunggu Validasi Admin',
                                            'under_review' => 'Sedang Direview Admin',
                                            'approved', 'published' => 'Prestasi Disetujui',
                                            'rejected' => 'Prestasi Ditolak',
                                            default => 'Status Prestasi',
                                        };

                                        $statusMessage = match ($prestasi->status) {
                                            'submitted' => 'Pengajuan sudah terkirim ke admin dan sedang menunggu proses validasi.',
                                            'under_review' => 'Admin sedang memeriksa data prestasi dan file bukti.',
                                            'approved', 'published' => 'Prestasi sudah divalidasi dan dapat ditampilkan pada portofolio public.',
                                            'rejected' => 'Prestasi ditolak oleh admin. Silakan lihat catatan validasi.',
                                            default => 'Status prestasi sedang diproses.',
                                        };

                                        $tanggalPrestasi = $prestasi->tanggal_prestasi
                                            ? \Illuminate\Support\Carbon::parse($prestasi->tanggal_prestasi)->format('d M Y')
                                            : '-';

                                        $catatanValidasi = $prestasi->catatan_validasi
                                            ?? $prestasi->validasiPrestasis->first()?->catatan
                                            ?? null;
                                    @endphp

                                    <article class="prestasi-card">
                                        <div class="prestasi-icon">
                                            🏆
                                        </div>

                                        <div>
                                            <div class="prestasi-head">
                                                <div class="prestasi-badges">
                                                    <span class="ep-badge ep-badge-blue">
                                                        {{ $prestasi->kategoriPrestasi->nama ?? 'Tanpa Kategori' }}
                                                    </span>

                                                    <span class="ep-badge ep-badge-purple">
                                                        {{ ucfirst((string) $prestasi->tingkat) }}
                                                    </span>

                                                    <span class="ep-badge {{ $statusColor }}">
                                                        {{ $statusLabel }}
                                                    </span>
                                                </div>

                                                <span class="ep-badge {{ $prestasi->ditampilkan ? 'ep-badge-green' : 'ep-badge-gray' }}">
                                                    {{ $prestasi->ditampilkan ? 'Public' : 'Non Public' }}
                                                </span>
                                            </div>

                                            <h2 class="prestasi-title">
                                                {{ $prestasi->judul }}
                                            </h2>

                                            <div class="prestasi-info-grid">
                                                <div class="prestasi-info">
                                                    <span>Penyelenggara</span>
                                                    <strong>{{ $prestasi->penyelenggara ?? '-' }}</strong>
                                                </div>

                                                <div class="prestasi-info">
                                                    <span>Jenis</span>
                                                    <strong>{{ $prestasi->jenis_prestasi ?? '-' }}</strong>
                                                </div>

                                                <div class="prestasi-info">
                                                    <span>Tanggal</span>
                                                    <strong>{{ $tanggalPrestasi }}</strong>
                                                </div>

                                                <div class="prestasi-info">
                                                    <span>File Bukti</span>
                                                    <strong>{{ $prestasi->filePrestasis->count() }} file</strong>
                                                </div>
                                            </div>

                                            @if ($prestasi->deskripsi)
                                                <p class="prestasi-desc">
                                                    {{ $prestasi->deskripsi }}
                                                </p>
                                            @endif

                                            <div class="prestasi-status-box {{ $statusBoxClass }}">
                                                <div style="font-size: 24px;">
                                                    {{ $statusIcon }}
                                                </div>

                                                <div>
                                                    <h4>{{ $statusTitle }}</h4>

                                                    <p>
                                                        {{ $statusMessage }}
                                                    </p>

                                                    @if ($prestasi->status === 'rejected' && $catatanValidasi)
                                                        <p style="margin-top: 8px;">
                                                            <strong>Catatan Admin:</strong>
                                                            {{ $catatanValidasi }}
                                                        </p>
                                                    @endif
                                                </div>

                                                @if (! $prestasi->canBeModifiedByMahasiswa())
                                                    <span class="ep-badge ep-badge-gray">
                                                        Terkunci
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="prestasi-actions">
                                                @if ($prestasi->canBeModifiedByMahasiswa())
                                                    <a href="{{ route('mahasiswa.prestasi.edit', $prestasi) }}" class="ep-btn ep-btn-dark">
                                                        Edit
                                                    </a>

                                                    <button
                                                        type="button"
                                                        wire:click="deletePrestasi({{ $prestasi->id }})"
                                                        wire:confirm="Yakin ingin menghapus prestasi ini?"
                                                        class="ep-btn ep-btn-danger"
                                                    >
                                                        Hapus
                                                    </button>
                                                @else
                                                    <span class="ep-btn ep-btn-white" style="cursor: default;">
                                                        Terkunci - sudah terkirim admin
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <div style="margin-top: 22px;">
                                {{ $prestasis->links() }}
                            </div>
                        @endif
                    </section>

                    <aside class="prestasi-summary">
                        <div class="ep-card ep-card-pad">
                            <h2 class="ep-section-title" style="font-size: 26px;">
                                Ringkasan
                            </h2>

                            <p class="ep-section-subtitle" style="font-size: 14px;">
                                Gunakan filter untuk mencari pengajuan prestasi berdasarkan status atau tingkat.
                            </p>

                            <div style="display: grid; gap: 12px; margin-top: 20px;">
                                <div class="summary-row">
                                    <div class="ep-icon-circle green" style="width: 46px; height: 46px; border-radius: 16px; font-size: 20px;">✓</div>
                                    <div>
                                        <strong>Approved</strong>
                                        <span>Tampil setelah validasi admin.</span>
                                    </div>
                                    <span class="ep-badge ep-badge-green">Valid</span>
                                </div>

                                <div class="summary-row">
                                    <div class="ep-icon-circle yellow" style="width: 46px; height: 46px; border-radius: 16px; font-size: 20px;">⏳</div>
                                    <div>
                                        <strong>Submitted</strong>
                                        <span>Sudah terkirim ke admin.</span>
                                    </div>
                                    <span class="ep-badge ep-badge-yellow">Review</span>
                                </div>

                                <div class="summary-row">
                                    <div class="ep-icon-circle red" style="width: 46px; height: 46px; border-radius: 16px; font-size: 20px;">!</div>
                                    <div>
                                        <strong>Rejected</strong>
                                        <span>Lihat catatan dari admin.</span>
                                    </div>
                                    <span class="ep-badge ep-badge-red">Tolak</span>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </main>
</div>