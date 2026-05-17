<?php

namespace App\Filament\Admin\Resources\PrestasiResource\RelationManagers;

use App\Models\FilePrestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class FilePrestasisRelationManager extends RelationManager
{
    protected static string $relationship = 'filePrestasis';

    protected static ?string $title = 'File Bukti Prestasi';

    protected static ?string $modelLabel = 'File Prestasi';

    protected static ?string $pluralModelLabel = 'File Prestasi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('path_file')
                    ->label('File Bukti')
                    ->disk('public')
                    ->directory('bukti-prestasi')
                    ->visibility('public')
                    ->acceptedFileTypes([
                        'application/pdf',
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ])
                    ->maxSize(2048)
                    ->downloadable()
                    ->openable()
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('nama_file')
                    ->label('Nama File')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('tipe_file')
                    ->label('Tipe File')
                    ->options([
                        'pdf' => 'PDF',
                        'jpg' => 'JPG',
                        'jpeg' => 'JPEG',
                        'png' => 'PNG',
                    ])
                    ->native(false)
                    ->required(),

                Forms\Components\TextInput::make('ukuran_file')
                    ->label('Ukuran File')
                    ->numeric()
                    ->suffix('bytes'),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_file')
            ->columns([
                Tables\Columns\TextColumn::make('nama_file')
                    ->label('Nama File')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('tipe_file')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'pdf' => 'danger',
                        'jpg', 'jpeg', 'png' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('ukuran_file')
                    ->label('Ukuran')
                    ->formatStateUsing(function ($state): string {
                        if (blank($state)) {
                            return '-';
                        }

                        return number_format((int) $state / 1024, 2) . ' KB';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diupload')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah File')
                    ->mutateFormDataUsing(function (array $data): array {
                        if (! empty($data['path_file'])) {
                            $path = $data['path_file'];

                            $data['nama_file'] = $data['nama_file'] ?: basename($path);
                            $data['tipe_file'] = $data['tipe_file'] ?: pathinfo($path, PATHINFO_EXTENSION);

                            if (Storage::disk('public')->exists($path)) {
                                $data['ukuran_file'] = Storage::disk('public')->size($path);
                            }
                        }

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (FilePrestasi $record): ?string => $record->path_file
                        ? asset('storage/' . ltrim($record->path_file, '/'))
                        : null)
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (! empty($data['path_file'])) {
                            $path = $data['path_file'];

                            $data['nama_file'] = $data['nama_file'] ?: basename($path);
                            $data['tipe_file'] = $data['tipe_file'] ?: pathinfo($path, PATHINFO_EXTENSION);

                            if (Storage::disk('public')->exists($path)) {
                                $data['ukuran_file'] = Storage::disk('public')->size($path);
                            }
                        }

                        return $data;
                    }),

                Tables\Actions\DeleteAction::make()
                    ->before(function (FilePrestasi $record): void {
                        if ($record->path_file) {
                            Storage::disk('public')->delete($record->path_file);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}