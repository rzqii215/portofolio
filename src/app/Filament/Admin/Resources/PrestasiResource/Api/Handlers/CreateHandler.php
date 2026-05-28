<?php
namespace App\Filament\Admin\Resources\PrestasiResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\PrestasiResource;
use App\Filament\Admin\Resources\PrestasiResource\Api\Requests\CreatePrestasiRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = PrestasiResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Prestasi
     *
     * @param CreatePrestasiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreatePrestasiRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}