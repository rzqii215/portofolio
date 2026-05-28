<?php

namespace App\Filament\Admin\Resources\ProfilMahasiswaResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\ProfilMahasiswaResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\ProfilMahasiswaResource\Api\Transformers\ProfilMahasiswaTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ProfilMahasiswaResource::class;


    /**
     * Show ProfilMahasiswa
     *
     * @param Request $request
     * @return ProfilMahasiswaTransformer
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

        return new ProfilMahasiswaTransformer($query);
    }
}
