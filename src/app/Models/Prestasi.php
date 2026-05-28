<?php

namespace App\Models;

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
        'tingkat',
        'penyelenggara',
        'jenis_prestasi',
        'tanggal_prestasi',
        'deskripsi',
        'status',
        'file_bukti',
        'ditampilkan',
        'ditampilkan_di_public',
        'catatan_admin',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'tanggal_prestasi' => 'date',
        'validated_at' => 'datetime',
        'ditampilkan' => 'boolean',
        'ditampilkan_di_public' => 'boolean',
    ];

    public static function getAllowedFields(): array
    {
        return [
            'id',
            'user_id',
            'kategori_prestasi_id',
            'judul',
            'tingkat',
            'penyelenggara',
            'jenis_prestasi',
            'tanggal_prestasi',
            'deskripsi',
            'status',
            'file_bukti',
            'ditampilkan',
            'ditampilkan_di_public',
            'catatan_admin',
            'validated_by',
            'validated_at',
            'created_at',
            'updated_at',
        ];
    }

    public static function getAllowedSorts(): array
    {
        return [
            'id',
            'judul',
            'tingkat',
            'penyelenggara',
            'jenis_prestasi',
            'tanggal_prestasi',
            'status',
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
            'tingkat',
            'penyelenggara',
            'jenis_prestasi',
            'status',
            'ditampilkan',
            'ditampilkan_di_public',
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

    public function riwayatStatusPrestasis(): HasMany
    {
        return $this->hasMany(RiwayatStatusPrestasi::class);
    }

    public function validasiPrestasis(): HasMany
    {
        return $this->hasMany(ValidasiPrestasi::class);
    }
}