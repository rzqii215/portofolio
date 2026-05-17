<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PengaturanPortofolio;
use App\Models\Prestasi;
use App\Models\ProfilMahasiswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EPortfolioStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalMahasiswa = ProfilMahasiswa::query()->count();

        $totalPrestasi = Prestasi::query()->count();

        $prestasiApproved = Prestasi::query()
            ->whereIn('status', ['approved', 'published'])
            ->count();

        $prestasiPending = Prestasi::query()
            ->whereIn('status', ['submitted', 'under_review'])
            ->count();

        $prestasiRejected = Prestasi::query()
            ->where('status', 'rejected')
            ->count();

        $portofolioPublic = PengaturanPortofolio::query()
            ->where('public', true)
            ->count();

        return [
            Stat::make('Total Mahasiswa', $totalMahasiswa)
                ->description('Jumlah profil mahasiswa')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Total Prestasi', $totalPrestasi)
                ->description('Seluruh prestasi mahasiswa')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('info'),

            Stat::make('Prestasi Disetujui', $prestasiApproved)
                ->description('Status approved / published')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Menunggu Validasi', $prestasiPending)
                ->description('Submitted / under review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Prestasi Ditolak', $prestasiRejected)
                ->description('Status rejected')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Portofolio Public', $portofolioPublic)
                ->description('Portofolio aktif public')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('success'),
        ];
    }
}