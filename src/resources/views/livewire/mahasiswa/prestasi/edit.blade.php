<div>
    <style>
        .prestasi-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .prestasi-form-full {
            grid-column: 1 / -1;
        }

        .file-list {
            display: grid;
            gap: 10px;
        }

        .file-item {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 10px;
            align-items: center;
            border: 1px solid var(--ep-border);
            background: #ffffff;
            border-radius: 17px;
            padding: 13px 14px;
        }

        .upload-box {
            border: 1px dashed #93c5fd;
            border-radius: 24px;
            padding: 22px;
            background: #f8fbff;
        }

        .edit-warning {
            display: grid;
            grid-template-columns: 54px 1fr;
            gap: 14px;
            align-items: center;
            padding: 18px;
            border-radius: 22px;
            background: #fef3c7;
            border: 1px solid #fde68a;
            color: #92400e;
            margin-bottom: 22px;
        }

        .edit-warning h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 900;
        }

        .edit-warning p {
            margin: 4px 0 0;
            font-size: 14px;
            line-height: 1.6;
        }

        .prestasi-form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        @media (max-width: 760px) {
            .prestasi-form-grid,
            .file-item {
                grid-template-columns: 1fr;
            }

            .prestasi-form-actions,
            .prestasi-form-actions .ep-btn {
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
                        Edit Prestasi
                    </p>

                    <h1 class="ep-title">
                        Perbarui Data <span>Prestasi</span>
                    </h1>

                    <p class="ep-subtitle">
                        Edit hanya tersedia untuk data yang belum terkirim ke admin. Jika sudah submitted, data akan dikunci.
                    </p>

                    <div class="ep-actions">
                        <a href="{{ route('mahasiswa.prestasi.index') }}" class="ep-btn ep-btn-white">
                            Kembali
                        </a>

                        <a href="{{ route('mahasiswa.dashboard') }}" class="ep-btn ep-btn-ghost">
                            Dashboard
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

                <form wire:submit.prevent="save" class="ep-card ep-card-pad">
                    <div class="edit-warning">
                        <div class="ep-icon-circle yellow" style="width: 54px; height: 54px;">
                            !
                        </div>

                        <div>
                            <h3>
                                Edit hanya untuk prestasi yang belum terkirim
                            </h3>

                            <p>
                                Setelah pengajuan dikirim ke admin, data prestasi akan dikunci agar proses validasi tetap rapi.
                            </p>
                        </div>
                    </div>

                    <h2 class="ep-section-title" style="font-size: 28px; margin-bottom: 20px;">
                        Data Prestasi
                    </h2>

                    <div class="prestasi-form-grid">
                        <div class="prestasi-form-full">
                            <label class="ep-form-label">
                                Judul Prestasi
                            </label>

                            <input
                                type="text"
                                wire:model="judul"
                                placeholder="Contoh: Juara 1 Web Design Competition"
                            >

                            @error('judul')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Kategori Prestasi
                            </label>

                            <select wire:model="kategori_prestasi_id">
                                <option value="">Pilih kategori</option>

                                @foreach ($kategoriPrestasis as $kategoriPrestasi)
                                    <option value="{{ $kategoriPrestasi->id }}">
                                        {{ $kategoriPrestasi->nama }}
                                    </option>
                                @endforeach
                            </select>

                            @error('kategori_prestasi_id')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Tingkat Prestasi
                            </label>

                            <select wire:model="tingkat">
                                <option value="">Pilih tingkat</option>
                                <option value="kampus">Kampus</option>
                                <option value="regional">Regional</option>
                                <option value="nasional">Nasional</option>
                                <option value="internasional">Internasional</option>
                            </select>

                            @error('tingkat')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Penyelenggara
                            </label>

                            <input
                                type="text"
                                wire:model="penyelenggara"
                                placeholder="Contoh: Dicoding Indonesia"
                            >

                            @error('penyelenggara')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Jenis Prestasi
                            </label>

                            <input
                                type="text"
                                wire:model="jenis_prestasi"
                                placeholder="Contoh: Kompetisi, Seminar, Magang"
                            >

                            @error('jenis_prestasi')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Tanggal Prestasi
                            </label>

                            <input
                                type="date"
                                wire:model="tanggal_prestasi"
                            >

                            @error('tanggal_prestasi')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="prestasi-form-full">
                            <label class="ep-form-label">
                                Deskripsi
                            </label>

                            <textarea
                                wire:model="deskripsi"
                                placeholder="Jelaskan prestasi yang diraih secara singkat dan jelas"
                            ></textarea>

                            @error('deskripsi')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="prestasi-form-full">
                            <label class="ep-form-label">
                                File Bukti Saat Ini
                            </label>

                            @if ($prestasi && $prestasi->filePrestasis->isNotEmpty())
                                <div class="file-list">
                                    @foreach ($prestasi->filePrestasis as $filePrestasi)
                                        <div class="file-item">
                                            <strong style="color: var(--ep-text);">
                                                {{ $filePrestasi->nama_file ?? basename((string) $filePrestasi->path_file) }}
                                            </strong>

                                            @if ($filePrestasi->path_file)
                                                <a
                                                    href="{{ asset('storage/' . $filePrestasi->path_file) }}"
                                                    target="_blank"
                                                    class="ep-btn ep-btn-white"
                                                >
                                                    Lihat
                                                </a>
                                            @endif

                                            <button
                                                type="button"
                                                wire:click="deleteFile({{ $filePrestasi->id }})"
                                                wire:confirm="Yakin ingin menghapus file ini?"
                                                class="ep-btn ep-btn-danger"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="ep-alert ep-alert-warning">
                                    Belum ada file bukti.
                                </div>
                            @endif
                        </div>

                        <div class="prestasi-form-full">
                            <label class="ep-form-label">
                                Tambah File Bukti Baru
                            </label>

                            <div class="upload-box">
                                <input
                                    type="file"
                                    wire:model="file_buktis"
                                    multiple
                                    accept=".pdf,.jpg,.jpeg,.png"
                                >

                                <p class="ep-help">
                                    Format PDF, JPG, JPEG, PNG. Maksimal 2MB per file.
                                </p>

                                @error('file_buktis')
                                    <p class="ep-error">{{ $message }}</p>
                                @enderror

                                @error('file_buktis.*')
                                    <p class="ep-error">{{ $message }}</p>
                                @enderror

                                @if ($file_buktis)
                                    <div class="file-list" style="margin-top: 16px;">
                                        @foreach ($file_buktis as $file)
                                            <div class="file-item">
                                                <strong>
                                                    {{ $file->getClientOriginalName() }}
                                                </strong>

                                                <span class="ep-badge ep-badge-blue">
                                                    Baru
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="prestasi-form-actions">
                        <a href="{{ route('mahasiswa.prestasi.index') }}" class="ep-btn ep-btn-white">
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="ep-btn ep-btn-primary"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>
                                Simpan Perubahan
                            </span>

                            <span wire:loading>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>