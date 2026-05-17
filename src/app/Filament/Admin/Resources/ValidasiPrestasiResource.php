<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ValidasiPrestasiResource\Pages;
use App\Models\ValidasiPrestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ValidasiPrestasiResource extends Resource
{
    protected static ?string $model = ValidasiPrestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'E-Portfolio';

    protected static ?string $navigationLabel = 'Validasi Prestasi';

    protected static ?string $modelLabel = 'Validasi Prestasi';

    protected static ?string $pluralModelLabel = 'Validasi Prestasi';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Validasi')
                    ->schema([
                        Forms\Components\Select::make('prestasi_id')
                            ->label('Prestasi')
                            ->relationship('prestasi', 'judul')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('validator_id')
                            ->label('Validator/Admin')
                            ->relationship('validator', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status Validasi')
                            ->options([
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\DateTimePicker::make('divalidasi_pada')
                            ->label('Divalidasi Pada')
                            ->native(false)
                            ->seconds(false),

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

                Tables\Columns\TextColumn::make('validator.name')
                    ->label('Validator')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(40)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('divalidasi_pada')
                    ->label('Tanggal Validasi')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('validator_id')
                    ->label('Validator')
                    ->relationship('validator', 'name'),
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
            'index' => Pages\ListValidasiPrestasis::route('/'),
            'create' => Pages\CreateValidasiPrestasi::route('/create'),
            'edit' => Pages\EditValidasiPrestasi::route('/{record}/edit'),
        ];
    }
}