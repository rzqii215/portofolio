<?php

namespace App\Filament\Admin\Resources\FilePrestasiResource\Pages;

use App\Filament\Admin\Resources\FilePrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFilePrestasis extends ListRecords
{
    protected static string $resource = FilePrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}