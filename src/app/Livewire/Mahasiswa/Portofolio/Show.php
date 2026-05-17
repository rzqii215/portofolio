<?php

namespace App\Livewire\Mahasiswa\Portofolio;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.portofolio')]
class Show extends Component
{
    public string $slug = '';

    public ?object $portofolio = null;

    public Collection $prestasis;

    public Collection $filesByPrestasi;

    public int $totalPrestasi = 0;

    public int $totalNasional = 0;

    public int $totalInternasional = 0;

    public int $totalKampusRegional = 0;

    public bool $notFound = false;

    public bool $notPublic = false;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->prestasis = collect();
        $this->filesByPrestasi = collect();

        $pengaturanColumns = DB::getSchemaBuilder()->getColumnListing('pengaturan_portofolios');

        $publicColumn = in_array('public', $pengaturanColumns, true)
            ? 'public'
            : (in_array('is_public', $pengaturanColumns, true) ? 'is_public' : null);

        $slugColumn = in_array('slug_public', $pengaturanColumns, true)
            ? 'slug_public'
            : (in_array('slug', $pengaturanColumns, true) ? 'slug' : null);

        if (! $slugColumn) {
            $this->notFound = true;

            return;
        }

        $query = DB::table('pengaturan_portofolios as pengaturan')
            ->join('profil_mahasiswas as profil', 'profil.id', '=', 'pengaturan.profil_mahasiswa_id')
            ->join('users as users', 'users.id', '=', 'profil.user_id')
            ->where("pengaturan.{$slugColumn}", $slug);

        $selects = [
            "pengaturan.{$slugColumn} as slug_public",
            'profil.id as profil_id',
            'profil.user_id',
            'profil.nim',
            'profil.nomor_hp',
            'profil.program_studi',
            'profil.fakultas',
            'profil.angkatan',
            'profil.alamat',
            'profil.bio',
            'profil.foto',
            'users.name',
            'users.email',
        ];

        if ($publicColumn) {
            $selects[] = "pengaturan.{$publicColumn} as is_public";
        }

        $portofolio = $query
            ->select($selects)
            ->first();

        if (! $portofolio) {
            $this->notFound = true;

            return;
        }

        if ($publicColumn && ! (bool) $portofolio->is_public) {
            $this->notPublic = true;
            $this->portofolio = $portofolio;

            return;
        }

        $this->portofolio = $portofolio;

        $this->loadPrestasis($portofolio->user_id);
    }

    private function loadPrestasis(int $userId): void
    {
        $prestasiColumns = DB::getSchemaBuilder()->getColumnListing('prestasis');

        $query = DB::table('prestasis as prestasi')
            ->leftJoin('kategori_prestasis as kategori', 'kategori.id', '=', 'prestasi.kategori_prestasi_id')
            ->where('prestasi.user_id', $userId);

        if (in_array('status', $prestasiColumns, true)) {
            $query->whereIn('prestasi.status', ['approved', 'published']);
        }

        if (in_array('ditampilkan', $prestasiColumns, true)) {
            $query->where('prestasi.ditampilkan', true);
        }

        $this->prestasis = $query
            ->select([
                'prestasi.id',
                'prestasi.judul',
                'prestasi.tingkat',
                'prestasi.penyelenggara',
                'prestasi.jenis_prestasi',
                'prestasi.tanggal_prestasi',
                'prestasi.deskripsi',
                'prestasi.status',
                'prestasi.ditampilkan',
                'kategori.nama as kategori_nama',
            ])
            ->orderByDesc('prestasi.tanggal_prestasi')
            ->orderByDesc('prestasi.id')
            ->get();

        $prestasiIds = $this->prestasis->pluck('id')->all();

        $this->filesByPrestasi = empty($prestasiIds)
            ? collect()
            : DB::table('file_prestasis')
                ->whereIn('prestasi_id', $prestasiIds)
                ->orderBy('id')
                ->get()
                ->groupBy('prestasi_id');

        $this->totalPrestasi = $this->prestasis->count();

        $this->totalNasional = $this->prestasis
            ->where('tingkat', 'nasional')
            ->count();

        $this->totalInternasional = $this->prestasis
            ->where('tingkat', 'internasional')
            ->count();

        $this->totalKampusRegional = $this->prestasis
            ->whereIn('tingkat', ['kampus', 'regional'])
            ->count();
    }

    public function render(): View
    {
        return view('livewire.portofolio.show');
    }
}