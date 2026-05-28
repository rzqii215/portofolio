<?php

namespace App\Filament\Admin\Resources\ValidasiPrestasiResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\ValidasiPrestasiResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\ValidasiPrestasiResource\Api\Transformers\ValidasiPrestasiTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ValidasiPrestasiResource::class;


    /**
     * Show ValidasiPrestasi
     *
     * @param Request $request
     * @return ValidasiPrestasiTransformer
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

        return new ValidasiPrestasiTransformer($query);
    }
}
