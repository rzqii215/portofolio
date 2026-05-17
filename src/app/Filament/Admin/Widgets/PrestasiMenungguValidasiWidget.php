<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\PrestasiResource;
use App\Models\Prestasi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PrestasiMenungguValidasiWidget extends BaseWidget
{
    protected static ?string $heading = 'Prestasi Menunggu Validasi';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Prestasi::query()
                    ->with([
                        'user',
                        'kategoriPrestasi',
                    ])
                    ->whereIn('status', ['submitted', 'under_review'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Mahasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategoriPrestasi.nama')
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Prestasi')
                    ->limit(55)
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'submitted' => 'warning',
                        'under_review' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('diajukan_pada')
                    ->label('Diajukan Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('validasi')
                    ->label('Validasi')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->color('success')
                    ->url(fn (Prestasi $record): string => PrestasiResource::getUrl('edit', [
                        'record' => $record,
                    ])),
            ])
            ->emptyStateHeading('Tidak ada prestasi menunggu validasi')
            ->emptyStateDescription('Semua prestasi mahasiswa sudah diproses.')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->paginated([5, 10]);
    }
}