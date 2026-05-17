<?php

namespace App\Livewire\Mahasiswa\Profil;

use App\Models\PengaturanPortofolio;
use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.mahasiswa')]
class Edit extends Component
{
    use WithFileUploads;

    public ?int $profilMahasiswaId = null;

    public ?int $pengaturanPortofolioId = null;

    public string $nama = '';

    public string $email = '';

    public string $nim = '';

    public ?string $nomor_hp = null;

    public ?string $program_studi = null;

    public ?string $fakultas = null;

    public ?string $angkatan = null;

    public ?string $alamat = null;

    public ?string $bio = null;

    public ?string $foto = null;

    public $foto_baru = null;

    public string $slug_public = '';

    public bool $is_public = false;

    public function mount(): void
    {
        $user = User::query()->findOrFail(Auth::id());

        $this->nama = $user->name ?? '';
        $this->email = $user->email ?? '';

        $profilMahasiswa = ProfilMahasiswa::query()->firstOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'nim' => 'REG-' . str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
                'nomor_hp' => '',
                'program_studi' => '',
                'fakultas' => '',
                'angkatan' => '',
                'alamat' => '',
                'foto' => null,
                'bio' => '',
            ]
        );

        $pengaturanPortofolio = PengaturanPortofolio::query()->firstOrCreate(
            [
                'profil_mahasiswa_id' => $profilMahasiswa->id,
            ],
            [
                'slug_public' => $this->generateUniqueSlug($user->name ?? 'mahasiswa'),
                'public' => false,
                'tema' => 'default',
            ]
        );

        $this->profilMahasiswaId = $profilMahasiswa->id;
        $this->pengaturanPortofolioId = $pengaturanPortofolio->id;

        $this->nim = (string) $profilMahasiswa->nim;
        $this->nomor_hp = $profilMahasiswa->nomor_hp;
        $this->program_studi = $profilMahasiswa->program_studi;
        $this->fakultas = $profilMahasiswa->fakultas;
        $this->angkatan = $profilMahasiswa->angkatan;
        $this->alamat = $profilMahasiswa->alamat;
        $this->bio = $profilMahasiswa->bio;
        $this->foto = $profilMahasiswa->foto;

        $this->slug_public = (string) $pengaturanPortofolio->slug_public;
        $this->is_public = (bool) $pengaturanPortofolio->public;
    }

    public function save(): void
    {
        $this->slug_public = Str::slug($this->slug_public);

        if ($this->slug_public === '') {
            $this->slug_public = $this->generateUniqueSlug(
                source: $this->nama . '-' . $this->nim,
                ignoreId: $this->pengaturanPortofolioId
            );
        }

        $validated = $this->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nim' => [
                'required',
                'string',
                'max:50',
                Rule::unique('profil_mahasiswas', 'nim')->ignore($this->profilMahasiswaId),
            ],
            'nomor_hp' => ['nullable', 'string', 'max:30'],
            'program_studi' => ['required', 'string', 'max:255'],
            'fakultas' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'string', 'max:10'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'slug_public' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pengaturan_portofolios', 'slug_public')->ignore($this->pengaturanPortofolioId),
            ],
            'is_public' => ['boolean'],
            'foto_baru' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = User::query()->findOrFail(Auth::id());

        $user->update([
            'name' => $validated['nama'],
        ]);

        $profilMahasiswa = ProfilMahasiswa::query()
            ->where('user_id', $user->id)
            ->firstOrFail();

        $fotoPath = $profilMahasiswa->foto;

        if ($this->foto_baru) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }

            $fotoPath = $this->foto_baru->store('profil-mahasiswa', 'public');
        }

        $profilMahasiswa->update([
            'nim' => $validated['nim'],
            'nomor_hp' => $validated['nomor_hp'] ?? '',
            'program_studi' => $validated['program_studi'],
            'fakultas' => $validated['fakultas'],
            'angkatan' => $validated['angkatan'],
            'alamat' => $validated['alamat'] ?? '',
            'bio' => $validated['bio'] ?? '',
            'foto' => $fotoPath,
        ]);

        PengaturanPortofolio::query()->updateOrCreate(
            [
                'profil_mahasiswa_id' => $profilMahasiswa->id,
            ],
            [
                'slug_public' => $validated['slug_public'],
                'public' => (bool) $validated['is_public'],
                'tema' => 'default',
            ]
        );

        session()->flash('success', 'Profil mahasiswa berhasil diperbarui.');

        $this->redirectRoute('mahasiswa.dashboard', navigate: false);
    }

    private function generateUniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($source);

        if ($baseSlug === '') {
            $baseSlug = 'mahasiswa';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            PengaturanPortofolio::query()
                ->where('slug_public', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId): void {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function render(): View
    {
        return view('livewire.mahasiswa.profil.edit');
    }
}