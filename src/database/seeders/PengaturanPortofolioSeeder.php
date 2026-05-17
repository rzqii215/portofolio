<?php

namespace Database\Seeders;

use App\Models\PengaturanPortofolio;
use App\Models\ProfilMahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PengaturanPortofolioSeeder extends Seeder
{
    public function run(): void
    {
        $profilMahasiswas = ProfilMahasiswa::query()
            ->with('user')
            ->get();

        foreach ($profilMahasiswas as $profilMahasiswa) {
            $nama = $profilMahasiswa->user?->name ?? 'mahasiswa';
            $nim = $profilMahasiswa->nim ?? $profilMahasiswa->id;

            $slug = match ($profilMahasiswa->user?->email) {
                'rizqi@example.com' => 'rizqi-candra',
                'bima@example.com' => 'bima-pratama',
                default => Str::slug($nama . '-' . $nim),
            };

            PengaturanPortofolio::query()->updateOrCreate(
                [
                    'profil_mahasiswa_id' => $profilMahasiswa->id,
                ],
                [
                    'slug_public' => $slug,
                    'public' => $profilMahasiswa->user?->email === 'rizqi@example.com',
                    'tema' => 'default',
                ]
            );
        }
    }
}