<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RiwayatStatusPrestasiResource\Pages;
use App\Models\RiwayatStatusPrestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RiwayatStatusPrestasiResource extends Resource
{
    protected static ?string $model = RiwayatStatusPrestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'E-Portfolio';

    protected static ?string $navigationLabel = 'Riwayat Status';

    protected static ?string $modelLabel = 'Riwayat Status Prestasi';

    protected static ?string $pluralModelLabel = 'Riwayat Status Prestasi';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Riwayat Perubahan Status')
                    ->schema([
                        Forms\Components\Select::make('prestasi_id')
                            ->label('Prestasi')
                            ->relationship('prestasi', 'judul')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('diubah_oleh')
                            ->label('Diubah Oleh')
                            ->relationship('diubahOleh', 'name')
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('status_lama')
                            ->label('Status Lama')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('status_baru')
                            ->label('Status Baru')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prestasi.judul')
                    ->label('Prestasi')
                    ->searchable()
                    ->sortable()
                    ->limit(45),

                Tables\Columns\TextColumn::make('prestasi.user.name')
                    ->label('Mahasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('diubahOleh.name')
                    ->label('Diubah Oleh')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('status_lama')
                    ->label('Status Lama')
                    ->badge()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('status_baru')
                    ->label('Status Baru')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'under_review' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'published' => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(50)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_baru')
                    ->label('Status Baru')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'published' => 'Published',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatStatusPrestasis::route('/'),
            'create' => Pages\CreateRiwayatStatusPrestasi::route('/create'),
            'edit' => Pages\EditRiwayatStatusPrestasi::route('/{record}/edit'),
        ];
    }
}