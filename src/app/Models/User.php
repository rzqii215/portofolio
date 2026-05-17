<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'avatar_url',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profilMahasiswa(): HasOne
    {
        return $this->hasOne(ProfilMahasiswa::class, 'user_id');
    }

    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'user_id');
    }

    public function validasiPrestasis(): HasMany
    {
        return $this->hasMany(ValidasiPrestasi::class, 'validator_id');
    }

    public function riwayatStatusPrestasis(): HasMany
    {
        return $this->hasMany(RiwayatStatusPrestasi::class, 'diubah_oleh');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url) {
            return asset('storage/' . $this->avatar_url);
        }

        $hash = md5(strtolower(trim($this->email)));

        return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole([
            'super_admin',
            'admin',
        ]);
    }

    public function isAdmin(): bool
    {
        return $this->hasAnyRole([
            'super_admin',
            'admin',
        ]);
    }

    public function isMahasiswa(): bool
    {
        return $this->hasRole('mahasiswa');
    }
}