<?php

namespace App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Pages;

use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRiwayatStatusPrestasi extends CreateRecord
{
    protected static string $resource = RiwayatStatusPrestasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['diubah_oleh'])) {
            $data['diubah_oleh'] = Auth::id();
        }

        return $data;
    }
}