<?php

namespace App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Api;

use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource;
use Rupadana\ApiService\ApiService;

class RiwayatStatusPrestasiApiService extends ApiService
{
    protected static string | null $resource = RiwayatStatusPrestasiResource::class;

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