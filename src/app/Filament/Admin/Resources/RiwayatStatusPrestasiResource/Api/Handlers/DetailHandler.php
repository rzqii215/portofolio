<?php

namespace App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Api\Transformers\RiwayatStatusPrestasiTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = RiwayatStatusPrestasiResource::class;


    /**
     * Show RiwayatStatusPrestasi
     *
     * @param Request $request
     * @return RiwayatStatusPrestasiTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new RiwayatStatusPrestasiTransformer($query);
    }
}
