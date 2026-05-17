<?php

namespace App\Livewire\Mahasiswa\Prestasi;

use App\Models\FilePrestasi;
use App\Models\KategoriPrestasi;
use App\Models\Prestasi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.mahasiswa')]
class Edit extends Component
{
    use WithFileUploads;

    public ?Prestasi $prestasi = null;

    public ?int $kategori_prestasi_id = null;

    public string $judul = '';

    public string $tingkat = '';

    public ?string $penyelenggara = null;

    public ?string $jenis_prestasi = null;

    public ?string $tanggal_prestasi = null;

    public ?string $deskripsi = null;

    public array $file_buktis = [];

    public function mount(Prestasi $prestasi): void
    {
        if ((int) $prestasi->user_id !== (int) Auth::id()) {
            abort(403);
        }

        if ($prestasi->isLockedForMahasiswa()) {
            session()->flash('error', 'Prestasi sudah terkirim ke admin sehingga tidak bisa diedit.');

            $this->redirectRoute('mahasiswa.prestasi.index', navigate: false);

            return;
        }

        $this->prestasi = $prestasi->load(['kategoriPrestasi', 'filePrestasis']);

        $this->kategori_prestasi_id = $prestasi->kategori_prestasi_id;
        $this->judul = (string) $prestasi->judul;
        $this->tingkat = (string) $prestasi->tingkat;
        $this->penyelenggara = $prestasi->penyelenggara;
        $this->jenis_prestasi = $prestasi->jenis_prestasi;
        $this->tanggal_prestasi = $prestasi->tanggal_prestasi
            ? $prestasi->tanggal_prestasi->format('Y-m-d')
            : null;
        $this->deskripsi = $prestasi->deskripsi;
    }

    public function save(): void
    {
        if (! $this->prestasi) {
            abort(404);
        }

        $prestasi = Prestasi::query()
            ->where('user_id', Auth::id())
            ->with('filePrestasis')
            ->findOrFail($this->prestasi->id);

        if ($prestasi->isLockedForMahasiswa()) {
            session()->flash('error', 'Prestasi sudah terkirim ke admin sehingga tidak bisa diedit.');

            $this->redirectRoute('mahasiswa.prestasi.index', navigate: false);

            return;
        }

        $validated = $this->validate([
            'kategori_prestasi_id' => ['required', 'integer', 'exists:kategori_prestasis,id'],
            'judul' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'string', 'in:kampus,regional,nasional,internasional'],
            'penyelenggara' => ['required', 'string', 'max:255'],
            'jenis_prestasi' => ['nullable', 'string', 'max:255'],
            'tanggal_prestasi' => ['required', 'date'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'file_buktis' => ['nullable', 'array'],
            'file_buktis.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        DB::transaction(function () use ($prestasi, $validated): void {
            $prestasi->update([
                'kategori_prestasi_id' => $validated['kategori_prestasi_id'],
                'judul' => $validated['judul'],
                'tingkat' => $validated['tingkat'],
                'penyelenggara' => $validated['penyelenggara'],
                'jenis_prestasi' => $validated['jenis_prestasi'] ?? null,
                'tanggal_prestasi' => $validated['tanggal_prestasi'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            foreach ($this->file_buktis as $file) {
                $this->insertFilePrestasi($prestasi, $file);
            }
        });

        session()->flash('success', 'Prestasi berhasil diperbarui.');

        $this->redirectRoute('mahasiswa.prestasi.index', navigate: false);
    }

    public function deleteFile(int $filePrestasiId): void
    {
        if (! $this->prestasi) {
            abort(404);
        }

        $prestasi = Prestasi::query()
            ->where('user_id', Auth::id())
            ->findOrFail($this->prestasi->id);

        if ($prestasi->isLockedForMahasiswa()) {
            session()->flash('error', 'Prestasi sudah terkirim ke admin sehingga file tidak bisa dihapus.');

            $this->redirectRoute('mahasiswa.prestasi.index', navigate: false);

            return;
        }

        $filePrestasi = FilePrestasi::query()
            ->where('prestasi_id', $prestasi->id)
            ->findOrFail($filePrestasiId);

        if ($filePrestasi->path_file) {
            Storage::disk('public')->delete($filePrestasi->path_file);
        }

        $filePrestasi->delete();

        $this->prestasi = $prestasi->fresh(['kategoriPrestasi', 'filePrestasis']);

        session()->flash('success', 'File bukti berhasil dihapus.');
    }

    private function insertFilePrestasi(Prestasi $prestasi, object $file): void
    {
        if (! Schema::hasTable('file_prestasis')) {
            return;
        }

        $path = $file->store('file-prestasi', 'public');

        $data = $this->onlyExistingColumns('file_prestasis', [
            'prestasi_id' => $prestasi->id,
            'nama_file' => $file->getClientOriginalName(),
            'nama' => $file->getClientOriginalName(),
            'path_file' => $path,
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'tipe_file' => $file->getMimeType(),
            'ukuran_file' => $file->getSize(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_prestasis')->insert($data);
    }

    private function onlyExistingColumns(string $table, array $data): array
    {
        return collect($data)
            ->filter(fn ($value, string $column): bool => Schema::hasColumn($table, $column))
            ->all();
    }

    public function render(): View
    {
        return view('livewire.mahasiswa.prestasi.edit', [
            'kategoriPrestasis' => KategoriPrestasi::query()
                ->orderBy('nama')
                ->get(),
        ]);
    }
}