<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriPrestasiSeeder::class,
            ProfilMahasiswaSeeder::class,
            PengaturanPortofolioSeeder::class,
            PrestasiSeeder::class,
            FilePrestasiSeeder::class,
            ValidasiPrestasiSeeder::class,
            RiwayatStatusPrestasiSeeder::class,
        ]);
    }
}