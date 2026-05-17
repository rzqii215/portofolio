<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanPortofolio extends Model
{
    protected $fillable = [
        'profil_mahasiswa_id',
        'slug_public',
        'public',
        'tema',
    ];

    protected function casts(): array
    {
        return [
            'public' => 'boolean',
        ];
    }

    public function profilMahasiswa(): BelongsTo
    {
        return $this->belongsTo(ProfilMahasiswa::class, 'profil_mahasiswa_id');
    }
}