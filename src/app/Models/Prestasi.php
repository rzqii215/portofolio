<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestasi extends Model
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
        'ditampilkan',
        'catatan_validasi',
        'divalidasi_oleh',
        'divalidasi_at',
    ];

    protected $casts = [
        'tanggal_prestasi' => 'date',
        'ditampilkan' => 'boolean',
        'divalidasi_at' => 'datetime',
    ];

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

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }

    public function isLockedForMahasiswa(): bool
    {
        return in_array($this->status, [
            'submitted',
            'under_review',
            'approved',
            'published',
            'rejected',
        ], true);
    }

    public function canBeModifiedByMahasiswa(): bool
    {
        return ! $this->isLockedForMahasiswa();
    }

    public function isApproved(): bool
    {
        return in_array($this->status, [
            'approved',
            'published',
        ], true);
    }

    public function isPublicVisible(): bool
    {
        return $this->isApproved() && (bool) $this->ditampilkan;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'Submitted',
            'under_review' => 'Under Review',
            'approved' => 'Approved',
            'published' => 'Published',
            'rejected' => 'Rejected',
            default => ucfirst((string) $this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'warning',
            'under_review' => 'info',
            'approved', 'published' => 'success',
            'rejected' => 'danger',
            default => 'gray',
        };
    }
}