<?php

namespace Database\Seeders;

use App\Models\KategoriPrestasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriPrestasis = [
            [
                'nama' => 'Akademik',
                'deskripsi' => 'Prestasi yang berkaitan dengan kegiatan akademik seperti lomba karya tulis ilmiah, olimpiade, dan kompetisi bidang studi.',
                'aktif' => true,
            ],
            [
                'nama' => 'Non Akademik',
                'deskripsi' => 'Prestasi di luar bidang akademik seperti olahraga, seni, budaya, dan kegiatan minat bakat.',
                'aktif' => true,
            ],
            [
                'nama' => 'Organisasi',
                'deskripsi' => 'Pencapaian mahasiswa dalam kegiatan organisasi kampus maupun luar kampus.',
                'aktif' => true,
            ],
            [
                'nama' => 'Sertifikasi',
                'deskripsi' => 'Prestasi atau pencapaian berupa sertifikat kompetensi, pelatihan, workshop, dan sertifikasi profesional.',
                'aktif' => true,
            ],
            [
                'nama' => 'Magang dan Proyek',
                'deskripsi' => 'Pencapaian mahasiswa dalam kegiatan magang, proyek industri, program kampus merdeka, atau project-based learning.',
                'aktif' => true,
            ],
        ];

        foreach ($kategoriPrestasis as $kategoriPrestasi) {
            KategoriPrestasi::query()->updateOrCreate(
                [
                    'slug' => Str::slug($kategoriPrestasi['nama']),
                ],
                [
                    'nama' => $kategoriPrestasi['nama'],
                    'deskripsi' => $kategoriPrestasi['deskripsi'],
                    'aktif' => $kategoriPrestasi['aktif'],
                ]
            );
        }
    }
}