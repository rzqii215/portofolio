<?php

namespace Database\Seeders;

use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfilMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $profilMahasiswas = [
            [
                'email' => 'rizqi@example.com',
                'nim' => '202401001',
                'nomor_hp' => '081234567890',
                'program_studi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Ilmu Komputer',
                'angkatan' => '2024',
                'alamat' => 'Jakarta Barat',
                'bio' => 'Mahasiswa Teknik Informatika yang memiliki minat pada pengembangan aplikasi web, sistem informasi, dan UI/UX.',
            ],
            [
                'email' => 'adel@example.com',
                'nim' => '202401002',
                'nomor_hp' => '081234567891',
                'program_studi' => 'Sistem Informasi',
                'fakultas' => 'Fakultas Ilmu Komputer',
                'angkatan' => '2024',
                'alamat' => 'Tangerang',
                'bio' => 'Mahasiswa Sistem Informasi yang aktif dalam organisasi dan pengembangan sistem berbasis web.',
            ],
            [
                'email' => 'bima@example.com',
                'nim' => '202401003',
                'nomor_hp' => '081234567892',
                'program_studi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Ilmu Komputer',
                'angkatan' => '2024',
                'alamat' => 'Bekasi',
                'bio' => 'Mahasiswa yang fokus pada kompetisi pemrograman, jaringan komputer, dan pengembangan software.',
            ],
        ];

        foreach ($profilMahasiswas as $profilMahasiswa) {
            $user = User::query()
                ->where('email', $profilMahasiswa['email'])
                ->first();

            if (! $user) {
                continue;
            }

            ProfilMahasiswa::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'nim' => $profilMahasiswa['nim'],
                    'nomor_hp' => $profilMahasiswa['nomor_hp'],
                    'program_studi' => $profilMahasiswa['program_studi'],
                    'fakultas' => $profilMahasiswa['fakultas'],
                    'angkatan' => $profilMahasiswa['angkatan'],
                    'alamat' => $profilMahasiswa['alamat'],
                    'foto' => null,
                    'bio' => $profilMahasiswa['bio'],
                ]
            );
        }
    }
}