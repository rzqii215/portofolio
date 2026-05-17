<?php

namespace Database\Seeders;

use App\Models\KategoriPrestasi;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class PrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $akademik = KategoriPrestasi::query()->where('slug', 'akademik')->first();
        $sertifikasi = KategoriPrestasi::query()->where('slug', 'sertifikasi')->first();
        $magang = KategoriPrestasi::query()->where('slug', 'magang-dan-proyek')->first();

        $rizqi = User::query()->where('email', 'rizqi@example.com')->first();
        $bima = User::query()->where('email', 'bima@example.com')->first();

        if ($rizqi && $akademik) {
            Prestasi::query()->updateOrCreate(
                [
                    'user_id' => $rizqi->id,
                    'judul' => 'Juara 1 Web Design Competition Tingkat Nasional',
                ],
                [
                    'kategori_prestasi_id' => $akademik->id,
                    'deskripsi' => 'Meraih juara pertama pada kompetisi desain dan pengembangan website tingkat nasional.',
                    'penyelenggara' => 'Universitas Teknologi Indonesia',
                    'tingkat' => 'nasional',
                    'jenis_prestasi' => 'Lomba',
                    'tanggal_prestasi' => '2025-10-12',
                    'status' => 'approved',
                    'ditampilkan' => true,
                    'diajukan_pada' => now()->subDays(10),
                    'disetujui_pada' => now()->subDays(8),
                    'ditolak_pada' => null,
                ]
            );
        }

        if ($rizqi && $sertifikasi) {
            Prestasi::query()->updateOrCreate(
                [
                    'user_id' => $rizqi->id,
                    'judul' => 'Sertifikasi Laravel Web Developer',
                ],
                [
                    'kategori_prestasi_id' => $sertifikasi->id,
                    'deskripsi' => 'Menyelesaikan pelatihan dan sertifikasi pengembangan aplikasi web menggunakan Laravel.',
                    'penyelenggara' => 'Dicoding Academy',
                    'tingkat' => 'nasional',
                    'jenis_prestasi' => 'Sertifikasi',
                    'tanggal_prestasi' => '2025-08-20',
                    'status' => 'approved',
                    'ditampilkan' => true,
                    'diajukan_pada' => now()->subDays(20),
                    'disetujui_pada' => now()->subDays(18),
                    'ditolak_pada' => null,
                ]
            );
        }

        if ($rizqi && $magang) {
            Prestasi::query()->updateOrCreate(
                [
                    'user_id' => $rizqi->id,
                    'judul' => 'Project Sistem Informasi E-Portfolio Mahasiswa',
                ],
                [
                    'kategori_prestasi_id' => $magang->id,
                    'deskripsi' => 'Mengembangkan sistem e-portfolio prestasi mahasiswa berbasis web menggunakan Laravel, Filament, Livewire, dan MariaDB.',
                    'penyelenggara' => 'Project Tugas Akhir Pemrograman Web',
                    'tingkat' => 'kampus',
                    'jenis_prestasi' => 'Project',
                    'tanggal_prestasi' => '2026-05-15',
                    'status' => 'submitted',
                    'ditampilkan' => false,
                    'diajukan_pada' => now()->subDays(2),
                    'disetujui_pada' => null,
                    'ditolak_pada' => null,
                ]
            );
        }

        if ($bima && $akademik) {
            Prestasi::query()->updateOrCreate(
                [
                    'user_id' => $bima->id,
                    'judul' => 'Finalis Competitive Programming Regional',
                ],
                [
                    'kategori_prestasi_id' => $akademik->id,
                    'deskripsi' => 'Menjadi finalis pada kompetisi pemrograman tingkat regional.',
                    'penyelenggara' => 'Komunitas Programmer Indonesia',
                    'tingkat' => 'regional',
                    'jenis_prestasi' => 'Lomba',
                    'tanggal_prestasi' => '2025-11-05',
                    'status' => 'rejected',
                    'ditampilkan' => false,
                    'diajukan_pada' => now()->subDays(7),
                    'disetujui_pada' => null,
                    'ditolak_pada' => now()->subDays(5),
                ]
            );
        }
    }
}