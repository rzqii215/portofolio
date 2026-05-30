<?php

namespace App\Models;

use App\Models\Prestasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilePrestasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'prestasi_id',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
    ];

    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(Prestasi::class);
    }
}