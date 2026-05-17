<?php

namespace App\Livewire\Mahasiswa\Prestasi;

use App\Models\Prestasi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.mahasiswa')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $tingkat = '';

    public int $perPage = 10;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedTingkat(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->search = '';
        $this->status = '';
        $this->tingkat = '';
        $this->perPage = 10;

        $this->resetPage();
    }

    public function deletePrestasi(int $prestasiId): void
    {
        $prestasi = Prestasi::query()
            ->where('user_id', Auth::id())
            ->with('filePrestasis')
            ->findOrFail($prestasiId);

        if ($prestasi->isLockedForMahasiswa()) {
            session()->flash('error', 'Prestasi sudah terkirim ke admin sehingga tidak bisa dihapus.');

            return;
        }

        foreach ($prestasi->filePrestasis as $filePrestasi) {
            if ($filePrestasi->path_file) {
                Storage::disk('public')->delete($filePrestasi->path_file);
            }

            $filePrestasi->delete();
        }

        $prestasi->delete();

        session()->flash('success', 'Prestasi berhasil dihapus.');
    }

    public function render(): View
    {
        $prestasis = Prestasi::query()
            ->where('user_id', Auth::id())
            ->with([
                'kategoriPrestasi',
                'filePrestasis',
                'validasiPrestasis' => function ($query): void {
                    $query->latest();
                },
            ])
            ->when($this->search !== '', function ($query): void {
                $query->where(function ($query): void {
                    $query
                        ->where('judul', 'like', '%' . $this->search . '%')
                        ->orWhere('penyelenggara', 'like', '%' . $this->search . '%')
                        ->orWhere('jenis_prestasi', 'like', '%' . $this->search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== '', function ($query): void {
                $query->where('status', $this->status);
            })
            ->when($this->tingkat !== '', function ($query): void {
                $query->where('tingkat', $this->tingkat);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.mahasiswa.prestasi.index', [
            'prestasis' => $prestasis,
        ]);
    }
}