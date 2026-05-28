<?php
namespace App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource;
use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Api\Transformers\RiwayatStatusPrestasiTransformer;

class PaginationHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = RiwayatStatusPrestasiResource::class;


    /**
     * List of RiwayatStatusPrestasi
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function handler()
    {
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for($query)
        ->allowedFields($this->getAllowedFields() ?? [])
        ->allowedSorts($this->getAllowedSorts() ?? [])
        ->allowedFilters($this->getAllowedFilters() ?? [])
        ->allowedIncludes($this->getAllowedIncludes() ?? [])
        ->paginate(request()->query('per_page'))
        ->appends(request()->query());

        return RiwayatStatusPrestasiTransformer::collection($query);
    }
}
