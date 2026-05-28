<?php
namespace App\Filament\Admin\Resources\PrestasiResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\PrestasiResource;
use App\Filament\Admin\Resources\PrestasiResource\Api\Requests\UpdatePrestasiRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = PrestasiResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Prestasi
     *
     * @param UpdatePrestasiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdatePrestasiRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}