<?php

namespace App\Filament\Admin\Resources\PengaturanPortofolioResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePengaturanPortofolioRequest extends FormRequest
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
			'profil_mahasiswa_id' => 'required',
			'public' => 'required',
			'slug_public' => 'required',
			'tema' => 'required'
		];
    }
}
