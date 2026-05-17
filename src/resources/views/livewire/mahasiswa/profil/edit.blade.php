<div>
    <style>
        .profile-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .profile-form-full {
            grid-column: 1 / -1;
        }

        .profile-preview {
            display: grid;
            grid-template-columns: 110px 1fr;
            gap: 22px;
            align-items: center;
            margin-bottom: 28px;
        }

        .profile-avatar {
            width: 110px;
            height: 110px;
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

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-preview h2 {
            margin: 8px 0 0;
            color: var(--ep-text);
            font-size: 32px;
            line-height: 1.1;
            font-weight: 900;
            letter-spacing: -0.05em;
        }

        .profile-preview p {
            margin: 6px 0 0;
            color: var(--ep-muted);
        }

        .profile-divider {
            border: 0;
            border-top: 1px solid var(--ep-border);
            margin: 30px 0;
        }

        .profile-checkbox-card {
            display: grid;
            grid-template-columns: 22px 1fr;
            gap: 14px;
            align-items: flex-start;
            padding: 18px;
            border-radius: 20px;
            background: #f8fbff;
            border: 1px solid var(--ep-border);
            cursor: pointer;
        }

        .profile-checkbox-card input {
            width: 18px;
            height: 18px;
            margin-top: 3px;
        }

        .profile-checkbox-card strong {
            display: block;
            color: var(--ep-text);
            font-size: 15px;
            font-weight: 900;
        }

        .profile-checkbox-card span span {
            display: block;
            margin-top: 5px;
            color: var(--ep-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .profile-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        @media (max-width: 760px) {
            .profile-form-grid,
            .profile-preview {
                grid-template-columns: 1fr;
            }

            .profile-actions,
            .profile-actions .ep-btn {
                width: 100%;
            }
        }
    </style>

    @php
        $initial = strtoupper(substr($nama ?: 'M', 0, 1));
        $publicUrl = $slug_public ? route('portofolio.show', $slug_public) : null;
    @endphp

    <main>
        <section class="ep-hero">
            <div class="ep-hero-pattern"></div>

            <div class="ep-container">
                <div class="ep-hero-inner">
                    <p class="ep-eyebrow">
                        Profil Mahasiswa
                    </p>

                    <h1 class="ep-title">
                        Lengkapi Identitas dan <span>Portofolio Public</span>
                    </h1>

                    <p class="ep-subtitle">
                        Pastikan data profil lengkap agar halaman portofolio public kamu terlihat profesional dan nyaman dibaca.
                    </p>

                    <div class="ep-actions">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="ep-btn ep-btn-white">
                            Dashboard
                        </a>

                        <a href="{{ route('mahasiswa.prestasi.index') }}" class="ep-btn ep-btn-ghost">
                            Kelola Prestasi
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

                <form wire:submit.prevent="save" class="ep-card ep-card-pad">
                    <div class="profile-preview">
                        <div class="profile-avatar">
                            @if ($foto_baru)
                                <img src="{{ $foto_baru->temporaryUrl() }}" alt="Preview Foto">
                            @elseif ($foto)
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Profil">
                            @else
                                {{ $initial }}
                            @endif
                        </div>

                        <div>
                            <p class="ep-eyebrow" style="color: var(--ep-primary); background: var(--ep-primary-soft); border-color: var(--ep-primary-soft);">
                                Data Profil
                            </p>

                            <h2>
                                {{ $nama ?: 'Mahasiswa' }}
                            </h2>

                            <p>
                                {{ $email }}
                            </p>
                        </div>
                    </div>

                    <h2 class="ep-section-title" style="font-size: 28px; margin-bottom: 20px;">
                        Data Mahasiswa
                    </h2>

                    <div class="profile-form-grid">
                        <div class="profile-form-full">
                            <label class="ep-form-label">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                wire:model="nama"
                                placeholder="Masukkan nama lengkap"
                            >

                            @error('nama')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                wire:model="email"
                                readonly
                            >

                            <p class="ep-help">
                                Email digunakan sebagai akun login mahasiswa.
                            </p>
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Upload Foto Profil
                            </label>

                            <input
                                type="file"
                                wire:model="foto_baru"
                                accept="image/png,image/jpeg,image/jpg"
                            >

                            <p class="ep-help">
                                Format JPG, JPEG, PNG. Maksimal 2MB.
                            </p>

                            @error('foto_baru')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                NIM
                            </label>

                            <input
                                type="text"
                                wire:model="nim"
                                placeholder="Contoh: 202401001"
                            >

                            @error('nim')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Nomor HP
                            </label>

                            <input
                                type="text"
                                wire:model="nomor_hp"
                                placeholder="Contoh: 081234567890"
                            >

                            @error('nomor_hp')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Program Studi
                            </label>

                            <input
                                type="text"
                                wire:model="program_studi"
                                placeholder="Contoh: Teknik Informatika"
                            >

                            @error('program_studi')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Fakultas
                            </label>

                            <input
                                type="text"
                                wire:model="fakultas"
                                placeholder="Contoh: Fakultas Ilmu Komputer"
                            >

                            @error('fakultas')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Angkatan
                            </label>

                            <input
                                type="text"
                                wire:model="angkatan"
                                placeholder="Contoh: 2024"
                            >

                            @error('angkatan')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="ep-form-label">
                                Alamat
                            </label>

                            <input
                                type="text"
                                wire:model="alamat"
                                placeholder="Masukkan alamat"
                            >

                            @error('alamat')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="profile-form-full">
                            <label class="ep-form-label">
                                Bio
                            </label>

                            <textarea
                                wire:model="bio"
                                placeholder="Tulis deskripsi singkat tentang diri kamu"
                            ></textarea>

                            @error('bio')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <hr class="profile-divider">

                    <h2 class="ep-section-title" style="font-size: 28px; margin-bottom: 20px;">
                        Pengaturan Portofolio Public
                    </h2>

                    <div class="profile-form-grid">
                        <div class="profile-form-full">
                            <label class="ep-form-label">
                                Slug Public
                            </label>

                            <input
                                type="text"
                                wire:model="slug_public"
                                placeholder="contoh: rizqi-candra"
                            >

                            <p class="ep-help">
                                URL portofolio: /portofolio/{{ $slug_public ?: 'slug-kamu' }}
                            </p>

                            @error('slug_public')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="profile-form-full">
                            <label class="profile-checkbox-card">
                                <input
                                    type="checkbox"
                                    wire:model="is_public"
                                >

                                <span>
                                    <strong>
                                        Aktifkan portofolio public
                                    </strong>

                                    <span>
                                        Jika aktif, profil dan prestasi yang sudah disetujui admin dapat tampil pada direktori portofolio public.
                                    </span>
                                </span>
                            </label>

                            @error('is_public')
                                <p class="ep-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-actions">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="ep-btn ep-btn-white">
                            Batal
                        </a>

                        @if ($publicUrl)
                            <a href="{{ $publicUrl }}" target="_blank" class="ep-btn ep-btn-dark">
                                Lihat Portofolio
                            </a>
                        @endif

                        <button
                            type="submit"
                            class="ep-btn ep-btn-primary"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>
                                Simpan Profil
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