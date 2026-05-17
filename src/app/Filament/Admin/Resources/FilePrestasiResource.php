<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FilePrestasiResource\Pages;
use App\Models\FilePrestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FilePrestasiResource extends Resource
{
    protected static ?string $model = FilePrestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';

    protected static ?string $navigationGroup = 'E-Portfolio';

    protected static ?string $navigationLabel = 'File Prestasi';

    protected static ?string $modelLabel = 'File Prestasi';

    protected static ?string $pluralModelLabel = 'File Prestasi';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Prestasi')
                    ->schema([
                        Forms\Components\Select::make('prestasi_id')
                            ->label('Prestasi')
                            ->relationship('prestasi', 'judul')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\FileUpload::make('path_file')
                            ->label('Upload Bukti Prestasi')
                            ->directory('bukti-prestasi')
                            ->disk('public')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/jpeg',
                                'image/png',
                                'image/jpg',
                            ])
                            ->maxSize(2048)
                            ->downloadable()
                            ->openable()
                            ->required(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Informasi File')
                    ->schema([
                        Forms\Components\TextInput::make('nama_file')
                            ->label('Nama File')
                            ->maxLength(255)
                            ->helperText('Boleh dikosongkan, sistem akan mengambil nama dari file upload.'),

                        Forms\Components\TextInput::make('tipe_file')
                            ->label('Tipe File')
                            ->maxLength(50)
                            ->helperText('Contoh: pdf, jpg, png. Boleh dikosongkan.'),

                        Forms\Components\TextInput::make('ukuran_file')
                            ->label('Ukuran File')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false)
                            ->suffix('bytes'),
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

                Tables\Columns\TextColumn::make('nama_file')
                    ->label('Nama File')
                    ->searchable()
                    ->limit(35),

                Tables\Columns\TextColumn::make('tipe_file')
                    ->label('Tipe')
                    ->badge(),

                Tables\Columns\TextColumn::make('ukuran_file')
                    ->label('Ukuran')
                    ->formatStateUsing(function ($state): string {
                        if (blank($state)) {
                            return '-';
                        }

                        return number_format((int) $state / 1024, 2) . ' KB';
                    }),

                Tables\Columns\TextColumn::make('path_file')
                    ->label('File')
                    ->formatStateUsing(fn (): string => 'Lihat File')
                    ->url(function (FilePrestasi $record): ?string {
                        if (blank($record->path_file)) {
                            return null;
                        }

                        return asset('storage/' . ltrim($record->path_file, '/'));
                    })
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('prestasi_id')
                    ->label('Prestasi')
                    ->relationship('prestasi', 'judul'),
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
            'index' => Pages\ListFilePrestasis::route('/'),
            'create' => Pages\CreateFilePrestasi::route('/create'),
            'edit' => Pages\EditFilePrestasi::route('/{record}/edit'),
        ];
    }
}