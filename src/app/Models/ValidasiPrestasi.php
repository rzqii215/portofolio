<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ValidasiPrestasi extends Model
{
    protected $table = 'validasi_prestasis';

    protected $fillable = [
        'prestasi_id',
        'validator_id',
        'status',
        'catatan',
        'divalidasi_pada',
    ];

    protected $casts = [
        'divalidasi_pada' => 'datetime',
    ];

    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(Prestasi::class, 'prestasi_id');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}