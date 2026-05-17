<?php

namespace App\Filament\Admin\Resources\FilePrestasiResource\Pages;

use App\Filament\Admin\Resources\FilePrestasiResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateFilePrestasi extends CreateRecord
{
    protected static string $resource = FilePrestasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! empty($data['path_file'])) {
            $path = $data['path_file'];

            $data['nama_file'] = $data['nama_file'] ?: basename($path);
            $data['tipe_file'] = $data['tipe_file'] ?: pathinfo($path, PATHINFO_EXTENSION);

            if (Storage::disk('public')->exists($path)) {
                $data['ukuran_file'] = Storage::disk('public')->size($path);
            }
        }

        return $data;
    }
}