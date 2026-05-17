<?php

namespace App\Filament\Admin\Resources\PengaturanPortofolioResource\Pages;

use App\Filament\Admin\Resources\PengaturanPortofolioResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePengaturanPortofolio extends CreateRecord
{
    protected static string $resource = PengaturanPortofolioResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['slug_public'])) {
            $data['slug_public'] = Str::slug('portofolio-' . now()->timestamp);
        }

        $data['slug_public'] = Str::slug($data['slug_public']);

        if (empty($data['tema'])) {
            $data['tema'] = 'default';
        }

        return $data;
    }
}