<?php
namespace App\Filament\Admin\Resources\PrestasiResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Prestasi;

/**
 * @property Prestasi $resource
 */
class PrestasiTransformer extends JsonResource
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
