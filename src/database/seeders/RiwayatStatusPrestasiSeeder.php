<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use App\Models\RiwayatStatusPrestasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class RiwayatStatusPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()
            ->where('email', 'admin@admin.com')
            ->first();

        $prestasis = Prestasi::query()->get();

        foreach ($prestasis as $prestasi) {
            RiwayatStatusPrestasi::query()->updateOrCreate(
                [
                    'prestasi_id' => $prestasi->id,
                    'status_lama' => null,
                    'status_baru' => 'submitted',
                ],
                [
                    'diubah_oleh' => $prestasi->user_id,
                    'catatan' => 'Prestasi diajukan oleh mahasiswa.',
                    'created_at' => $prestasi->diajukan_pada ?? now(),
                    'updated_at' => $prestasi->diajukan_pada ?? now(),
                ]
            );

            if ($prestasi->status === 'approved') {
                RiwayatStatusPrestasi::query()->updateOrCreate(
                    [
                        'prestasi_id' => $prestasi->id,
                        'status_lama' => 'submitted',
                        'status_baru' => 'approved',
                    ],
                    [
                        'diubah_oleh' => $admin?->id,
                        'catatan' => 'Prestasi disetujui oleh admin.',
                        'created_at' => $prestasi->disetujui_pada ?? now(),
                        'updated_at' => $prestasi->disetujui_pada ?? now(),
                    ]
                );
            }

            if ($prestasi->status === 'rejected') {
                RiwayatStatusPrestasi::query()->updateOrCreate(
                    [
                        'prestasi_id' => $prestasi->id,
                        'status_lama' => 'submitted',
                        'status_baru' => 'rejected',
                    ],
                    [
                        'diubah_oleh' => $admin?->id,
                        'catatan' => 'Prestasi ditolak karena data atau bukti belum valid.',
                        'created_at' => $prestasi->ditolak_pada ?? now(),
                        'updated_at' => $prestasi->ditolak_pada ?? now(),
                    ]
                );
            }
        }
    }
}