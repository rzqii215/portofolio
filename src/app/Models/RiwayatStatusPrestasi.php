<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatStatusPrestasi extends Model
{
    protected $table = 'riwayat_status_prestasis';

    protected $fillable = [
        'prestasi_id',
        'diubah_oleh',
        'status_lama',
        'status_baru',
        'catatan',
    ];

    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(Prestasi::class, 'prestasi_id');
    }

    public function diubahOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }
}