<div>
    <style>
        .directory-toolbar {
            display: grid;
            grid-template-columns: 1fr 190px auto;
            gap: 14px;
            align-items: end;
        }

        .directory-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
            margin-top: 24px;
        }

        .student-card {
            position: relative;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--ep-border);
            border-radius: 30px;
            padding: 24px;
            box-shadow: var(--ep-shadow-sm);
            transition: 0.2s ease;
        }

        .student-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--ep-shadow-md);
        }

        .student-card::after {
            content: "";
            position: absolute;
            right: -45px;
            top: -45px;
            width: 130px;
            height: 130px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.08);
        }

        .student-head {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 78px 1fr;
            gap: 16px;
            align-items: center;
        }

        .student-avatar {
            width: 78px;
            height: 78px;
            border-radius: 24px;
            overflow: hidden;
            background: linear-gradient(135deg, #020617, #173b7a);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            font-weight: 900;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.18);
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-name {
            margin: 0;
            color: var(--ep-text);
            font-size: 22px;
            line-height: 1.18;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .student-email {
            margin: 5px 0 0;
            color: var(--ep-muted);
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .student-badges {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .student-bio {
            position: relative;
            z-index: 2;
            margin: 16px 0 0;
            color: #334155;
            line-height: 1.75;
            min-height: 78px;
        }

        .student-info {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 8px;
            margin-top: 18px;
            color: var(--ep-muted);
            font-size: 14px;
        }

        .student-info strong {
            color: var(--ep-text);
            font-weight: 900;
        }

        .student-action {
            position: relative;
            z-index: 2;
            margin-top: 22px;
        }

        .empty-directory {
            text-align: center;
            padding: 46px 28px;
            border: 1px dashed #cbd5e1;
            border-radius: 30px;
            background: #ffffff;
            box-shadow: var(--ep-shadow-sm);
            margin-top: 24px;
        }

        .empty-directory h2 {
            margin: 0;
            color: var(--ep-text);
            font-size: 30px;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .empty-directory p {
            max-width: 560px;
            margin: 10px auto 0;
            color: var(--ep-muted);
            line-height: 1.8;
        }

        @media (max-width: 1050px) {
            .directory-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .directory-toolbar,
            .directory-grid,
            .student-head {
                grid-template-columns: 1fr;
            }

            .directory-toolbar .ep-btn,
            .student-action .ep-btn {
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
                        Direktori Public
                    </p>

                    <h1 class="ep-title">
                        Temukan <span>Portofolio Mahasiswa</span>
                    </h1>

                    <p class="ep-subtitle">
                        Jelajahi profil mahasiswa dan prestasi yang sudah melewati proses validasi admin.
                    </p>
                </div>
            </div>
        </section>

        <section class="ep-section">
            <div class="ep-container">
                <div class="ep-card ep-card-pad">
                    <div class="directory-toolbar">
                        <div>
                            <label class="ep-form-label">
                                Cari Mahasiswa
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.500ms="search"
                                placeholder="Cari nama, NIM, prodi, fakultas, email, atau slug"
                            >
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Per Halaman
                            </label>

                            <select wire:model.live="perPage">
                                <option value="6">6</option>
                                <option value="9">9</option>
                                <option value="12">12</option>
                            </select>
                        </div>

                        <button type="button" wire:click="resetFilter" class="ep-btn ep-btn-dark">
                            Reset
                        </button>
                    </div>
                </div>

                @if ($portofolios->isEmpty())
                    <div class="empty-directory">
                        <h2>
                            Belum Ada Portofolio Public
                        </h2>

                        <p>
                            Portofolio akan tampil di sini ketika mahasiswa mengaktifkan portofolio public dan memiliki prestasi yang sudah disetujui admin.
                        </p>
                    </div>
                @else
                    <div class="directory-grid">
                        @foreach ($portofolios as $portofolio)
                            @php
                                $nama = $portofolio->name ?? 'Mahasiswa';
                                $initial = strtoupper(substr($nama, 0, 1));
                                $totalPrestasi = (int) ($portofolio->total_prestasi_public ?? 0);
                            @endphp

                            <article class="student-card">
                                <div class="student-head">
                                    <div class="student-avatar">
                                        @if ($portofolio->foto)
                                            <img src="{{ asset('storage/' . $portofolio->foto) }}" alt="Foto {{ $nama }}">
                                        @else
                                            {{ $initial }}
                                        @endif
                                    </div>

                                    <div>
                                        <h2 class="student-name">
                                            {{ $nama }}
                                        </h2>

                                        <p class="student-email">
                                            {{ $portofolio->email }}
                                        </p>
                                    </div>
                                </div>

                                <div class="student-badges">
                                    <span class="ep-badge ep-badge-blue">
                                        {{ $portofolio->program_studi ?: 'Program Studi' }}
                                    </span>

                                    <span class="ep-badge {{ $totalPrestasi > 0 ? 'ep-badge-green' : 'ep-badge-gray' }}">
                                        {{ $totalPrestasi }} Prestasi
                                    </span>
                                </div>

                                <p class="student-bio">
                                    {{ $portofolio->bio ?: 'Mahasiswa ini belum menambahkan bio pada profil portofolio public.' }}
                                </p>

                                <div class="student-info">
                                    <div>
                                        <strong>NIM:</strong>
                                        {{ $portofolio->nim ?: '-' }}
                                    </div>

                                    <div>
                                        <strong>Fakultas:</strong>
                                        {{ $portofolio->fakultas ?: '-' }}
                                    </div>

                                    <div>
                                        <strong>Angkatan:</strong>
                                        {{ $portofolio->angkatan ?: '-' }}
                                    </div>
                                </div>

                                <div class="student-action">
                                    <a href="{{ route('portofolio.show', $portofolio->slug_public) }}" class="ep-btn ep-btn-primary" style="width: 100%;">
                                        Lihat Portofolio
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div style="margin-top: 24px;">
                        {{ $portofolios->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>
</div>