<?php

namespace App\Filament\Admin\Resources\ProfilMahasiswaResource\Api;

use App\Filament\Admin\Resources\ProfilMahasiswaResource;
use Rupadana\ApiService\ApiService;

class ProfilMahasiswaApiService extends ApiService
{
    protected static string | null $resource = ProfilMahasiswaResource::class;

    public static function handlers(): array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class,
        ];
    }
}