<?php

namespace App\Filament\Admin\Resources\ValidasiPrestasiResource\Api;

use App\Filament\Admin\Resources\ValidasiPrestasiResource;
use Rupadana\ApiService\ApiService;

class ValidasiPrestasiApiService extends ApiService
{
    protected static string | null $resource = ValidasiPrestasiResource::class;

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