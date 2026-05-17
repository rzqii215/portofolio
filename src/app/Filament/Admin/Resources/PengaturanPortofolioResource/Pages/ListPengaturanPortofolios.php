<?php

namespace App\Filament\Admin\Resources\PengaturanPortofolioResource\Pages;

use App\Filament\Admin\Resources\PengaturanPortofolioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengaturanPortofolios extends ListRecords
{
    protected static string $resource = PengaturanPortofolioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}