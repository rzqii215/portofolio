<?php
namespace App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource;
use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Api\Requests\CreateRiwayatStatusPrestasiRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = RiwayatStatusPrestasiResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create RiwayatStatusPrestasi
     *
     * @param CreateRiwayatStatusPrestasiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateRiwayatStatusPrestasiRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}