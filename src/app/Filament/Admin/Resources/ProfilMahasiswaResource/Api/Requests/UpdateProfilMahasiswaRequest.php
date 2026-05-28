<?php

namespace App\Filament\Admin\Resources\ProfilMahasiswaResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilMahasiswaRequest extends FormRequest
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
			'user_id' => 'required',
			'nim' => 'required',
			'nomor_hp' => 'required',
			'program_studi' => 'required',
			'fakultas' => 'required',
			'angkatan' => 'required',
			'alamat' => 'required|string',
			'foto' => 'required',
			'bio' => 'required|string'
		];
    }
}
