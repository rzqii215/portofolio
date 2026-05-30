<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProfilMahasiswaResource\Pages;
use App\Models\ProfilMahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProfilMahasiswaResource extends Resource
{
    protected static ?string $model = ProfilMahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'E-Portofolio';

    protected static ?string $navigationLabel = 'Profil Mahasiswa';

    protected static ?string $modelLabel = 'Profil Mahasiswa';

    protected static ?string $pluralModelLabel = 'Profil Mahasiswa';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Akun')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Nama Mahasiswa')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->unique(
                                table: 'profil_mahasiswas',
                                column: 'user_id',
                                ignoreRecord: true
                            ),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Biodata Mahasiswa')
                    ->schema([
                        Forms\Components\TextInput::make('nim')
                            ->label('NIM')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),

                        Forms\Components\TextInput::make('nomor_hp')
                            ->label('Nomor HP')
                            ->tel()
                            ->maxLength(30),

                        Forms\Components\TextInput::make('program_studi')
                            ->label('Program Studi')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('fakultas')
                            ->label('Fakultas')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('angkatan')
                            ->label('Angkatan')
                            ->maxLength(10),

                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Profil')
                            ->image()
                            ->directory('profil-mahasiswa')
                            ->visibility('public')
                            ->maxSize(2048),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('bio')
                            ->label('Bio Singkat')
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
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('program_studi')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fakultas')
                    ->label('Fakultas')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('angkatan')
                    ->label('Angkatan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nomor_hp')
                    ->label('Nomor HP')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('program_studi')
                    ->label('Program Studi')
                    ->options(fn () => ProfilMahasiswa::query()
                        ->whereNotNull('program_studi')
                        ->pluck('program_studi', 'program_studi')
                        ->toArray()),

                Tables\Filters\SelectFilter::make('angkatan')
                    ->label('Angkatan')
                    ->options(fn () => ProfilMahasiswa::query()
                        ->whereNotNull('angkatan')
                        ->pluck('angkatan', 'angkatan')
                        ->toArray()),
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
            'index' => Pages\ListProfilMahasiswas::route('/'),
            'create' => Pages\CreateProfilMahasiswa::route('/create'),
            'edit' => Pages\EditProfilMahasiswa::route('/{record}/edit'),
        ];
    }
}