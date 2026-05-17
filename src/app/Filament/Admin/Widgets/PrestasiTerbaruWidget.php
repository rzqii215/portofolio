<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\PrestasiResource;
use App\Models\Prestasi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PrestasiTerbaruWidget extends BaseWidget
{
    protected static ?string $heading = 'Prestasi Terbaru';

    protected static ?int $sort = 2;

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
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Mahasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategoriPrestasi.nama')
                    ->label('Kategori')
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Prestasi')
                    ->limit(45)
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'kampus' => 'Kampus',
                        'lokal' => 'Lokal',
                        'regional' => 'Regional',
                        'nasional' => 'Nasional',
                        'internasional' => 'Internasional',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'kampus' => 'gray',
                        'lokal' => 'info',
                        'regional' => 'warning',
                        'nasional' => 'success',
                        'internasional' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'published' => 'Published',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'under_review' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'published' => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('ditampilkan')
                    ->label('Public')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Detail')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->url(fn (Prestasi $record): string => PrestasiResource::getUrl('edit', [
                        'record' => $record,
                    ])),
            ])
            ->paginated(false);
    }
}