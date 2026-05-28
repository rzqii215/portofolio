<?php

namespace App\Filament\Admin\Resources\PrestasiResource\Api;

use App\Filament\Admin\Resources\PrestasiResource;
use Rupadana\ApiService\ApiService;

class PrestasiApiService extends ApiService
{
    protected static string | null $resource = PrestasiResource::class;

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