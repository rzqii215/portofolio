<?php

namespace App\Livewire\Mahasiswa\Prestasi;

use App\Models\KategoriPrestasi;
use App\Models\Prestasi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.mahasiswa')]
class Create extends Component
{
    use WithFileUploads;

    public ?int $kategori_prestasi_id = null;

    public string $judul = '';

    public string $tingkat = '';

    public ?string $penyelenggara = null;

    public ?string $jenis_prestasi = null;

    public ?string $tanggal_prestasi = null;

    public ?string $deskripsi = null;

    public array $file_buktis = [];

    public function save(): void
    {
        $validated = $this->validate([
            'kategori_prestasi_id' => ['required', 'integer', 'exists:kategori_prestasis,id'],
            'judul' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'string', 'in:kampus,regional,nasional,internasional'],
            'penyelenggara' => ['required', 'string', 'max:255'],
            'jenis_prestasi' => ['nullable', 'string', 'max:255'],
            'tanggal_prestasi' => ['required', 'date'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'file_buktis' => ['required', 'array', 'min:1'],
            'file_buktis.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        DB::transaction(function () use ($validated): void {
            $prestasiData = $this->onlyExistingColumns('prestasis', [
                'user_id' => Auth::id(),
                'kategori_prestasi_id' => $validated['kategori_prestasi_id'],
                'judul' => $validated['judul'],
                'tingkat' => $validated['tingkat'],
                'penyelenggara' => $validated['penyelenggara'],
                'jenis_prestasi' => $validated['jenis_prestasi'] ?? null,
                'tanggal_prestasi' => $validated['tanggal_prestasi'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'status' => 'submitted',
                'ditampilkan' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $prestasiId = DB::table('prestasis')->insertGetId($prestasiData);

            $prestasi = Prestasi::query()->findOrFail($prestasiId);

            foreach ($this->file_buktis as $file) {
                $this->insertFilePrestasi($prestasi, $file);
            }

            $this->insertRiwayatStatus(
                prestasi: $prestasi,
                statusBaru: 'submitted',
                catatan: 'Prestasi diajukan oleh mahasiswa.'
            );
        });

        session()->flash('success', 'Prestasi berhasil diajukan ke admin.');

        $this->redirectRoute('mahasiswa.prestasi.index', navigate: false);
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
            'path' => $path,

            'mime_type' => $file->getMimeType(),
            'tipe_file' => $file->getMimeType(),

            'ukuran_file' => $file->getSize(),
            'size' => $file->getSize(),

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_prestasis')->insert($data);
    }

    private function insertRiwayatStatus(Prestasi $prestasi, string $statusBaru, ?string $catatan = null): void
    {
        if (! Schema::hasTable('riwayat_status_prestasis')) {
            return;
        }

        $data = $this->onlyExistingColumns('riwayat_status_prestasis', [
            'prestasi_id' => $prestasi->id,

            'user_id' => Auth::id(),
            'admin_id' => null,

            'status' => $statusBaru,
            'status_lama' => null,
            'status_baru' => $statusBaru,

            'catatan' => $catatan,
            'keterangan' => $catatan,

            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (Schema::hasColumn('riwayat_status_prestasis', 'status_baru')) {
            $data['status_baru'] = $statusBaru;
        }

        DB::table('riwayat_status_prestasis')->insert($data);
    }

    private function onlyExistingColumns(string $table, array $data): array
    {
        return collect($data)
            ->filter(fn ($value, string $column): bool => Schema::hasColumn($table, $column))
            ->all();
    }

    public function render(): View
    {
        return view('livewire.mahasiswa.prestasi.create', [
            'kategoriPrestasis' => KategoriPrestasi::query()
                ->orderBy('nama')
                ->get(),
        ]);
    }
}