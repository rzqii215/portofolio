<?php

namespace App\Filament\Admin\Resources\PrestasiResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrestasiRequest extends FormRequest
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
			'kategori_prestasi_id' => 'required',
			'judul' => 'required',
			'deskripsi' => 'required|string',
			'penyelenggara' => 'required',
			'tingkat' => 'required',
			'jenis_prestasi' => 'required',
			'tanggal_prestasi' => 'required|date',
			'status' => 'required',
			'ditampilkan' => 'required',
			'diajukan_pada' => 'required',
			'disetujui_pada' => 'required',
			'ditolak_pada' => 'required'
		];
    }
}
