<?php

namespace App\Livewire\Mahasiswa;

use App\Models\PengaturanPortofolio;
use App\Models\Prestasi;
use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.mahasiswa')]
class Dashboard extends Component
{
    public function render(): View
    {
        $user = User::query()->findOrFail(Auth::id());

        $profilMahasiswa = ProfilMahasiswa::query()
            ->where('user_id', $user->id)
            ->first();

        $pengaturanPortofolio = null;

        if ($profilMahasiswa) {
            $pengaturanPortofolio = PengaturanPortofolio::query()
                ->where('profil_mahasiswa_id', $profilMahasiswa->id)
                ->first();
        }

        $prestasis = Prestasi::query()
            ->where('user_id', $user->id)
            ->with(['kategoriPrestasi', 'filePrestasis'])
            ->latest()
            ->get();

        $totalPrestasi = $prestasis->count();

        $totalSubmitted = $prestasis
            ->where('status', 'submitted')
            ->count();

        $totalUnderReview = $prestasis
            ->where('status', 'under_review')
            ->count();

        $totalMenunggu = $prestasis
            ->whereIn('status', ['submitted', 'under_review'])
            ->count();

        $totalDisetujui = $prestasis
            ->whereIn('status', ['approved', 'published'])
            ->count();

        $totalDitolak = $prestasis
            ->where('status', 'rejected')
            ->count();

        $totalPublic = $prestasis
            ->whereIn('status', ['approved', 'published'])
            ->where('ditampilkan', true)
            ->count();

        $totalKampus = $prestasis
            ->where('tingkat', 'kampus')
            ->count();

        $totalRegional = $prestasis
            ->where('tingkat', 'regional')
            ->count();

        $totalNasional = $prestasis
            ->where('tingkat', 'nasional')
            ->count();

        $totalInternasional = $prestasis
            ->where('tingkat', 'internasional')
            ->count();

        $monthlyStats = collect(range(5, 0))
            ->map(function (int $monthBack) use ($prestasis): array {
                $month = now()->subMonths($monthBack);

                $count = $prestasis
                    ->filter(function (Prestasi $prestasi) use ($month): bool {
                        $date = $prestasi->tanggal_prestasi ?: $prestasi->created_at;

                        if (! $date) {
                            return false;
                        }

                        return Carbon::parse($date)->isSameMonth($month);
                    })
                    ->count();

                return [
                    'label' => $month->translatedFormat('M'),
                    'month' => $month->format('Y-m'),
                    'total' => $count,
                ];
            })
            ->values();

        $maxMonthlyTotal = max($monthlyStats->max('total') ?: 0, 1);

        $monthlyChart = $monthlyStats
            ->map(function (array $item) use ($maxMonthlyTotal): array {
                $height = $item['total'] > 0
                    ? max(18, (int) round(($item['total'] / $maxMonthlyTotal) * 100))
                    : 8;

                return [
                    'label' => $item['label'],
                    'total' => $item['total'],
                    'height' => $height,
                ];
            })
            ->all();

        $statusChart = [
            [
                'label' => 'Submitted',
                'total' => $totalSubmitted,
                'class' => 'submitted',
            ],
            [
                'label' => 'Review',
                'total' => $totalUnderReview,
                'class' => 'review',
            ],
            [
                'label' => 'Valid',
                'total' => $totalDisetujui,
                'class' => 'approved',
            ],
            [
                'label' => 'Ditolak',
                'total' => $totalDitolak,
                'class' => 'rejected',
            ],
        ];

        $tingkatChart = [
            [
                'label' => 'Kampus',
                'total' => $totalKampus,
                'class' => 'campus',
            ],
            [
                'label' => 'Regional',
                'total' => $totalRegional,
                'class' => 'regional',
            ],
            [
                'label' => 'Nasional',
                'total' => $totalNasional,
                'class' => 'national',
            ],
            [
                'label' => 'Internasional',
                'total' => $totalInternasional,
                'class' => 'international',
            ],
        ];

        $prestasisTerbaru = $prestasis->take(5);

        return view('livewire.mahasiswa.dashboard', [
            'user' => $user,
            'profilMahasiswa' => $profilMahasiswa,
            'pengaturanPortofolio' => $pengaturanPortofolio,

            'totalPrestasi' => $totalPrestasi,
            'totalSubmitted' => $totalSubmitted,
            'totalUnderReview' => $totalUnderReview,
            'totalMenunggu' => $totalMenunggu,
            'totalDisetujui' => $totalDisetujui,
            'totalDitolak' => $totalDitolak,
            'totalPublic' => $totalPublic,

            'totalKampus' => $totalKampus,
            'totalRegional' => $totalRegional,
            'totalNasional' => $totalNasional,
            'totalInternasional' => $totalInternasional,

            'monthlyChart' => $monthlyChart,
            'statusChart' => $statusChart,
            'tingkatChart' => $tingkatChart,

            'prestasisTerbaru' => $prestasisTerbaru,
        ]);
    }
}