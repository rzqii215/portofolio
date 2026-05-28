<?php
namespace App\Filament\Admin\Resources\ProfilMahasiswaResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\ProfilMahasiswaResource;
use App\Filament\Admin\Resources\ProfilMahasiswaResource\Api\Requests\CreateProfilMahasiswaRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ProfilMahasiswaResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create ProfilMahasiswa
     *
     * @param CreateProfilMahasiswaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateProfilMahasiswaRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}