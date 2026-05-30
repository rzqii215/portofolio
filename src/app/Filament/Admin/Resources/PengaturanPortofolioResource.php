<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PengaturanPortofolioResource\Pages;
use App\Models\PengaturanPortofolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PengaturanPortofolioResource extends Resource
{
    protected static ?string $model = PengaturanPortofolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'E-Portofolio';

    protected static ?string $navigationLabel = 'Pengaturan Portofolio';

    protected static ?string $modelLabel = 'Pengaturan Portofolio';

    protected static ?string $pluralModelLabel = 'Pengaturan Portofolio';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Portofolio')
                    ->schema([
                        Forms\Components\Select::make('profil_mahasiswa_id')
                            ->label('Profil Mahasiswa')
                            ->relationship('profilMahasiswa', 'nim')
                            ->getOptionLabelFromRecordUsing(function ($record): string {
                                $nama = $record->user?->name ?? 'Tanpa Nama';
                                $nim = $record->nim ?? '-';

                                return "{$nama} - {$nim}";
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->unique(
                                table: 'pengaturan_portofolios',
                                column: 'profil_mahasiswa_id',
                                ignoreRecord: true
                            ),

                        Forms\Components\TextInput::make('slug_public')
                            ->label('Slug Public')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Contoh: rizqi-candra. Nanti URL menjadi /portofolio/rizqi-candra'),

                        Forms\Components\Select::make('tema')
                            ->label('Tema Portofolio')
                            ->options([
                                'default' => 'Default',
                                'minimal' => 'Minimal',
                                'modern' => 'Modern',
                            ])
                            ->default('default')
                            ->required()
                            ->native(false),

                        Forms\Components\Toggle::make('public')
                            ->label('Aktifkan Portofolio Public')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('profilMahasiswa.user.name')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('profilMahasiswa.nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug_public')
                    ->label('Slug Public')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug berhasil disalin'),

                Tables\Columns\TextColumn::make('tema')
                    ->label('Tema')
                    ->badge(),

                Tables\Columns\IconColumn::make('public')
                    ->label('Public')
                    ->boolean(),

                Tables\Columns\TextColumn::make('link_portofolio')
                    ->label('Link')
                    ->state(fn (PengaturanPortofolio $record): string => url('/portofolio/' . $record->slug_public))
                    ->url(fn (PengaturanPortofolio $record): string => url('/portofolio/' . $record->slug_public))
                    ->openUrlInNewTab()
                    ->copyable()
                    ->copyMessage('Link portofolio berhasil disalin')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('public')
                    ->label('Status Public')
                    ->trueLabel('Public')
                    ->falseLabel('Private')
                    ->native(false),

                Tables\Filters\SelectFilter::make('tema')
                    ->label('Tema')
                    ->options([
                        'default' => 'Default',
                        'minimal' => 'Minimal',
                        'modern' => 'Modern',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('buka_portofolio')
                    ->label('Buka')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('info')
                    ->url(fn (PengaturanPortofolio $record): string => url('/portofolio/' . $record->slug_public))
                    ->openUrlInNewTab(),

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
            'index' => Pages\ListPengaturanPortofolios::route('/'),
            'create' => Pages\CreatePengaturanPortofolio::route('/create'),
            'edit' => Pages\EditPengaturanPortofolio::route('/{record}/edit'),
        ];
    }
}