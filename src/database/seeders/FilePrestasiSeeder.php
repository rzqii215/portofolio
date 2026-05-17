<?php

namespace Database\Seeders;

use App\Models\FilePrestasi;
use App\Models\Prestasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FilePrestasiSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('bukti-prestasi');

        $dummyPdfContent = "%PDF-1.4\n% Dummy PDF file untuk bukti prestasi seeder\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF";

        $prestasis = Prestasi::query()
            ->whereIn('status', ['approved', 'submitted', 'rejected'])
            ->get();

        foreach ($prestasis as $prestasi) {
            $fileName = 'bukti-prestasi/prestasi-' . $prestasi->id . '.pdf';

            if (! Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->put($fileName, $dummyPdfContent);
            }

            FilePrestasi::query()->updateOrCreate(
                [
                    'prestasi_id' => $prestasi->id,
                    'path_file' => $fileName,
                ],
                [
                    'nama_file' => 'Bukti Prestasi - ' . $prestasi->judul . '.pdf',
                    'tipe_file' => 'pdf',
                    'ukuran_file' => Storage::disk('public')->size($fileName),
                ]
            );
        }
    }
}