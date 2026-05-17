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

        .upload-box {
            border: 1px dashed #93c5fd;
            border-radius: 24px;
            padding: 22px;
            background: #f8fbff;
        }

        .upload-preview {
            display: grid;
            gap: 10px;
            margin-top: 16px;
        }

        .upload-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border: 1px solid var(--ep-border);
            background: #ffffff;
            border-radius: 16px;
            padding: 12px 14px;
            color: var(--ep-text);
            font-size: 14px;
            font-weight: 800;
        }

        .form-note {
            display: grid;
            grid-template-columns: 54px 1fr;
            gap: 14px;
            align-items: center;
            padding: 18px;
            border-radius: 22px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            margin-bottom: 22px;
        }

        .form-note h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 900;
        }

        .form-note p {
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
            .prestasi-form-grid {
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
                        Tambah Prestasi
                    </p>

                    <h1 class="ep-title">
                        Ajukan Prestasi ke <span>Admin</span>
                    </h1>

                    <p class="ep-subtitle">
                        Isi detail prestasi dan upload file bukti. Setelah disimpan, pengajuan akan terkirim ke admin dan tidak bisa diedit atau dihapus.
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
                <form wire:submit.prevent="save" class="ep-card ep-card-pad">
                    <div class="form-note">
                        <div class="ep-icon-circle" style="width: 54px; height: 54px;">
                            ⏳
                        </div>

                        <div>
                            <h3>
                                Data akan langsung dikirim ke admin
                            </h3>

                            <p>
                                Pastikan data dan file bukti sudah benar sebelum mengajukan prestasi.
                            </p>
                        </div>
                    </div>

                    <h2 class="ep-section-title" style="font-size: 28px; margin-bottom: 20px;">
                        Informasi Prestasi
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
                                File Bukti
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
                                    <div class="upload-preview">
                                        @foreach ($file_buktis as $file)
                                            <div class="upload-item">
                                                <span>
                                                    {{ $file->getClientOriginalName() }}
                                                </span>

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
                                Ajukan ke Admin
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