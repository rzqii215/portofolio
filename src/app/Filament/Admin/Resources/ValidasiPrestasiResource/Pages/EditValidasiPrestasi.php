<?php

namespace App\Filament\Admin\Resources\ValidasiPrestasiResource\Pages;

use App\Filament\Admin\Resources\ValidasiPrestasiResource;
use App\Models\RiwayatStatusPrestasi;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditValidasiPrestasi extends EditRecord
{
    protected static string $resource = ValidasiPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['divalidasi_pada'])) {
            $data['divalidasi_pada'] = now();
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $validasi = $this->record;
        $prestasi = $validasi->prestasi;

        if (! $prestasi) {
            return;
        }

        $statusLama = $prestasi->status;
        $statusBaru = $validasi->status;

        $prestasi->update([
            'status' => $statusBaru,
            'ditampilkan' => $statusBaru === 'approved',
            'disetujui_pada' => $statusBaru === 'approved' ? now() : null,
            'ditolak_pada' => $statusBaru === 'rejected' ? now() : null,
        ]);

        RiwayatStatusPrestasi::create([
            'prestasi_id' => $prestasi->id,
            'diubah_oleh' => Auth::id(),
            'status_lama' => $statusLama,
            'status_baru' => $statusBaru,
            'catatan' => $validasi->catatan,
        ]);
    }
}