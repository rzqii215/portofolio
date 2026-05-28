<?php
namespace App\Filament\Admin\Resources\ProfilMahasiswaResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProfilMahasiswa;

/**
 * @property ProfilMahasiswa $resource
 */
class ProfilMahasiswaTransformer extends JsonResource
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
