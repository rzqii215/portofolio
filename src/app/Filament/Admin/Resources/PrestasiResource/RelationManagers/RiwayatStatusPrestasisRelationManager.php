<?php

namespace App\Filament\Admin\Resources\PrestasiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RiwayatStatusPrestasisRelationManager extends RelationManager
{
    protected static string $relationship = 'riwayatStatusPrestasis';

    protected static ?string $title = 'Riwayat Status';

    protected static ?string $modelLabel = 'Riwayat Status';

    protected static ?string $pluralModelLabel = 'Riwayat Status';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status_baru')
            ->columns([
                Tables\Columns\TextColumn::make('diubahOleh.name')
                    ->label('Diubah Oleh')
                    ->placeholder('System / Mahasiswa')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status_lama')
                    ->label('Status Lama')
                    ->badge()
                    ->placeholder('-')
                    ->formatStateUsing(fn (?string $state): string => $state
                        ? strtoupper(str_replace('_', ' ', $state))
                        : '-')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status_baru')
                    ->label('Status Baru')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state
                        ? strtoupper(str_replace('_', ' ', $state))
                        : '-')
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
                    ->limit(70)
                    ->wrap()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }
}