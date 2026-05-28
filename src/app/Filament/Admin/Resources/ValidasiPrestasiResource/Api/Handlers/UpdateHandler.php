<?php
namespace App\Filament\Admin\Resources\ValidasiPrestasiResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\ValidasiPrestasiResource;
use App\Filament\Admin\Resources\ValidasiPrestasiResource\Api\Requests\UpdateValidasiPrestasiRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = ValidasiPrestasiResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update ValidasiPrestasi
     *
     * @param UpdateValidasiPrestasiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateValidasiPrestasiRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}