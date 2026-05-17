<?php

namespace App\Filament\Admin\Resources\ValidasiPrestasiResource\Pages;

use App\Filament\Admin\Resources\ValidasiPrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValidasiPrestasis extends ListRecords
{
    protected static string $resource = ValidasiPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}