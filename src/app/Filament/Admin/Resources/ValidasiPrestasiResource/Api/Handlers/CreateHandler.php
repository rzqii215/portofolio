<?php
namespace App\Filament\Admin\Resources\ValidasiPrestasiResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\ValidasiPrestasiResource;
use App\Filament\Admin\Resources\ValidasiPrestasiResource\Api\Requests\CreateValidasiPrestasiRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ValidasiPrestasiResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create ValidasiPrestasi
     *
     * @param CreateValidasiPrestasiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateValidasiPrestasiRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}