<?php

namespace App\Filament\Admin\Resources\PrestasiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ValidasiPrestasisRelationManager extends RelationManager
{
    protected static string $relationship = 'validasiPrestasis';

    protected static ?string $title = 'Riwayat Validasi';

    protected static ?string $modelLabel = 'Validasi Prestasi';

    protected static ?string $pluralModelLabel = 'Validasi Prestasi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('validator_id')
                    ->label('Validator')
                    ->relationship('validator', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->native(false)
                    ->required(),

                Forms\Components\DateTimePicker::make('divalidasi_pada')
                    ->label('Divalidasi Pada')
                    ->native(false)
                    ->seconds(false)
                    ->required(),

                Forms\Components\Textarea::make('catatan')
                    ->label('Catatan')
                    ->rows(4)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                Tables\Columns\TextColumn::make('validator.name')
                    ->label('Validator')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(70)
                    ->wrap()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('divalidasi_pada')
                    ->label('Tanggal Validasi')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('divalidasi_pada', 'desc');
    }
}