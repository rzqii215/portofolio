<?php

namespace App\Livewire\Mahasiswa\Portofolio;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.portofolio')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 6;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->search = '';
        $this->perPage = 6;

        $this->resetPage();
    }

    public function render(): View
    {
        $portofolios = DB::table('profil_mahasiswas as profil')
            ->join('users as users', 'users.id', '=', 'profil.user_id')
            ->join('pengaturan_portofolios as pengaturan', 'pengaturan.profil_mahasiswa_id', '=', 'profil.id')
            ->where('pengaturan.public', true)
            ->when($this->search !== '', function ($query): void {
                $query->where(function ($query): void {
                    $query
                        ->where('users.name', 'like', '%' . $this->search . '%')
                        ->orWhere('users.email', 'like', '%' . $this->search . '%')
                        ->orWhere('profil.nim', 'like', '%' . $this->search . '%')
                        ->orWhere('profil.program_studi', 'like', '%' . $this->search . '%')
                        ->orWhere('profil.fakultas', 'like', '%' . $this->search . '%')
                        ->orWhere('profil.angkatan', 'like', '%' . $this->search . '%')
                        ->orWhere('pengaturan.slug_public', 'like', '%' . $this->search . '%');
                });
            })
            ->select([
                'profil.id',
                'profil.user_id',
                'profil.nim',
                'profil.program_studi',
                'profil.fakultas',
                'profil.angkatan',
                'profil.bio',
                'profil.foto',
                'users.name',
                'users.email',
                'pengaturan.slug_public',
            ])
            ->selectSub(function ($query): void {
                $query
                    ->from('prestasis')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('prestasis.user_id', 'profil.user_id')
                    ->whereIn('prestasis.status', ['approved', 'published'])
                    ->where('prestasis.ditampilkan', true);
            }, 'total_prestasi_public')
            ->orderBy('users.name')
            ->paginate($this->perPage);

        return view('livewire.portofolio.index', [
            'portofolios' => $portofolios,
        ]);
    }
}