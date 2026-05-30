<?php

namespace App\Models;

use App\Models\FilePrestasi;
use App\Models\KategoriPrestasi;
use App\Models\RiwayatStatusPrestasi;
use App\Models\User;
use App\Models\ValidasiPrestasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rupadana\ApiService\Contracts\HasAllowedFields;
use Rupadana\ApiService\Contracts\HasAllowedFilters;
use Rupadana\ApiService\Contracts\HasAllowedSorts;

class Prestasi extends Model implements HasAllowedFields, HasAllowedFilters, HasAllowedSorts
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_prestasi_id',
        'judul',
        'deskripsi',
        'penyelenggara',
        'tingkat',
        'jenis_prestasi',
        'tanggal_prestasi',
        'status',
        'ditampilkan',
        'diajukan_pada',
        'disetujui_pada',
        'ditolak_pada',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_prestasi' => 'date',
        'ditampilkan' => 'boolean',
        'diajukan_pada' => 'datetime',
        'disetujui_pada' => 'datetime',
        'ditolak_pada' => 'datetime',
    ];

    public static function getAllowedFields(): array
    {
        return [
            'id',
            'user_id',
            'kategori_prestasi_id',
            'judul',
            'deskripsi',
            'penyelenggara',
            'tingkat',
            'jenis_prestasi',
            'tanggal_prestasi',
            'status',
            'ditampilkan',
            'diajukan_pada',
            'disetujui_pada',
            'ditolak_pada',
            'catatan_admin',
            'created_at',
            'updated_at',
        ];
    }

    public static function getAllowedSorts(): array
    {
        return [
            'id',
            'judul',
            'penyelenggara',
            'tingkat',
            'jenis_prestasi',
            'tanggal_prestasi',
            'status',
            'ditampilkan',
            'created_at',
            'updated_at',
        ];
    }

    public static function getAllowedFilters(): array
    {
        return [
            'id',
            'user_id',
            'kategori_prestasi_id',
            'judul',
            'penyelenggara',
            'tingkat',
            'jenis_prestasi',
            'status',
            'ditampilkan',
            'created_at',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriPrestasi(): BelongsTo
    {
        return $this->belongsTo(KategoriPrestasi::class);
    }

    public function filePrestasis(): HasMany
    {
        return $this->hasMany(FilePrestasi::class);
    }

    public function validasiPrestasis(): HasMany
    {
        return $this->hasMany(ValidasiPrestasi::class);
    }

    public function riwayatStatusPrestasis(): HasMany
    {
        return $this->hasMany(RiwayatStatusPrestasi::class);
    }
}