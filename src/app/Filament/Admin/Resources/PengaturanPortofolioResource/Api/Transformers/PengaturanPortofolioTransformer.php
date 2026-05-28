<?php
namespace App\Filament\Admin\Resources\PengaturanPortofolioResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PengaturanPortofolio;

/**
 * @property PengaturanPortofolio $resource
 */
class PengaturanPortofolioTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
