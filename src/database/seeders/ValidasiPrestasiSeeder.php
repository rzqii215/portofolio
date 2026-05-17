<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use App\Models\User;
use App\Models\ValidasiPrestasi;
use Illuminate\Database\Seeder;

class ValidasiPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $validator = User::query()
            ->where('email', 'admin@example.com')
            ->first();

        if (! $validator) {
            return;
        }

        $prestasis = Prestasi::query()
            ->whereIn('status', ['approved', 'rejected'])
            ->get();

        foreach ($prestasis as $prestasi) {
            ValidasiPrestasi::query()->updateOrCreate(
                [
                    'prestasi_id' => $prestasi->id,
                    'validator_id' => $validator->id,
                    'status' => $prestasi->status,
                ],
                [
                    'catatan' => $prestasi->status === 'approved'
                        ? 'Prestasi valid dan bukti telah sesuai.'
                        : 'Data prestasi belum sesuai atau bukti pendukung belum valid.',
                    'divalidasi_pada' => $prestasi->status === 'approved'
                        ? ($prestasi->disetujui_pada ?? now())
                        : ($prestasi->ditolak_pada ?? now()),
                ]
            );
        }
    }
}