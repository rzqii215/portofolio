<?php

namespace App\Filament\Admin\Resources\PengaturanPortofolioResource\Api;

use App\Filament\Admin\Resources\PengaturanPortofolioResource;
use Rupadana\ApiService\ApiService;

class PengaturanPortofolioApiService extends ApiService
{
    protected static string | null $resource = PengaturanPortofolioResource::class;

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