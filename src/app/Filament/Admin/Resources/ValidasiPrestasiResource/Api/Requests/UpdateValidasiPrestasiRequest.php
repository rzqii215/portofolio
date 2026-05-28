<?php

namespace App\Filament\Admin\Resources\ValidasiPrestasiResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateValidasiPrestasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'prestasi_id' => 'required',
			'validator_id' => 'required',
			'status' => 'required',
			'catatan' => 'required|string',
			'divalidasi_pada' => 'required'
		];
    }
}
