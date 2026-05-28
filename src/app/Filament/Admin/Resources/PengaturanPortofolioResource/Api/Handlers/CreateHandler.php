<?php
namespace App\Filament\Admin\Resources\PengaturanPortofolioResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\PengaturanPortofolioResource;
use App\Filament\Admin\Resources\PengaturanPortofolioResource\Api\Requests\CreatePengaturanPortofolioRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = PengaturanPortofolioResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create PengaturanPortofolio
     *
     * @param CreatePengaturanPortofolioRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreatePengaturanPortofolioRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}