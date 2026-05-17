<?php

namespace App\Filament\Admin\Resources\PengaturanPortofolioResource\Pages;

use App\Filament\Admin\Resources\PengaturanPortofolioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditPengaturanPortofolio extends EditRecord
{
    protected static string $resource = PengaturanPortofolioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['slug_public'])) {
            $data['slug_public'] = Str::slug($data['slug_public']);
        }

        if (empty($data['tema'])) {
            $data['tema'] = 'default';
        }

        return $data;
    }
}