<?php

namespace App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Pages;

use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatStatusPrestasis extends ListRecords
{
    protected static string $resource = RiwayatStatusPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}