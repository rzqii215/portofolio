<?php

namespace App\Http\Controllers;

use App\Models\PengaturanPortofolio;
use Illuminate\Contracts\View\View;

class PortofolioPublicController extends Controller
{
    public function show(string $slug): View
    {
        $pengaturanPortofolio = PengaturanPortofolio::query()
            ->where('slug_public', $slug)
            ->where('public', true)
            ->with([
                'profilMahasiswa.user',
                'profilMahasiswa.user.prestasis' => function ($query) {
                    $query
                        ->whereIn('status', ['approved', 'published'])
                        ->where('ditampilkan', true)
                        ->with([
                            'kategoriPrestasi',
                            'filePrestasis',
                        ])
                        ->latest('tanggal_prestasi');
                },
            ])
            ->firstOrFail();

        return view('portofolio.show', [
            'pengaturanPortofolio' => $pengaturanPortofolio,
            'profilMahasiswa' => $pengaturanPortofolio->profilMahasiswa,
            'user' => $pengaturanPortofolio->profilMahasiswa->user,
            'prestasis' => $pengaturanPortofolio->profilMahasiswa->user->prestasis,
        ]);
    }
}