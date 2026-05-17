<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfilMahasiswa extends Model
{
    protected $fillable = [
        'user_id',
        'nim',
        'nomor_hp',
        'program_studi',
        'fakultas',
        'angkatan',
        'alamat',
        'foto',
        'bio',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pengaturanPortofolio(): HasOne
    {
        return $this->hasOne(PengaturanPortofolio::class, 'profil_mahasiswa_id');
    }
}