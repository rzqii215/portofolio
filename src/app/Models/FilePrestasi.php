<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilePrestasi extends Model
{
    protected $table = 'file_prestasis';

    protected $fillable = [
        'prestasi_id',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
    ];

    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(Prestasi::class, 'prestasi_id');
    }
}