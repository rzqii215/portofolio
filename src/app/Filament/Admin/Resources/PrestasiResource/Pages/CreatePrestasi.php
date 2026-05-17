<?php

namespace App\Filament\Admin\Resources\PrestasiResource\Pages;

use App\Filament\Admin\Resources\PrestasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePrestasi extends CreateRecord
{
    protected static string $resource = PrestasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['diajukan_pada'])) {
            $data['diajukan_pada'] = now();
        }

        return $data;
    }
}