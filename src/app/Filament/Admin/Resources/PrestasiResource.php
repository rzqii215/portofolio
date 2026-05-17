<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PrestasiResource\Pages;
use App\Models\Prestasi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PrestasiResource extends Resource
{
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'E-Portfolio';

    protected static ?string $navigationLabel = 'Prestasi Mahasiswa';

    protected static ?string $modelLabel = 'Prestasi Mahasiswa';

    protected static ?string $pluralModelLabel = 'Prestasi Mahasiswa';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Mahasiswa')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Mahasiswa')
                            ->options(function (): array {
                                return User::query()
                                    ->whereHas('roles', function ($query): void {
                                        $query->where('name', 'mahasiswa');
                                    })
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('kategori_prestasi_id')
                            ->label('Kategori Prestasi')
                            ->relationship('kategoriPrestasi', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Data Prestasi')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Prestasi')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('penyelenggara')
                            ->label('Penyelenggara')
                            ->maxLength(255),

                        Forms\Components\Select::make('tingkat')
                            ->label('Tingkat Prestasi')
                            ->options([
                                'kampus' => 'Kampus',
                                'lokal' => 'Lokal',
                                'regional' => 'Regional',
                                'nasional' => 'Nasional',
                                'internasional' => 'Internasional',
                            ])
                            ->native(false)
                            ->required(),

                        Forms\Components\TextInput::make('jenis_prestasi')
                            ->label('Jenis Prestasi')
                            ->placeholder('Contoh: Lomba, Sertifikasi, Organisasi, Project')
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('tanggal_prestasi')
                            ->label('Tanggal Prestasi')
                            ->native(false),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi Prestasi')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status dan Publikasi')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Submitted',
                                'under_review' => 'Under Review',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                'published' => 'Published',
                            ])
                            ->native(false)
                            ->default('submitted')
                            ->required(),

                        Forms\Components\Toggle::make('ditampilkan')
                            ->label('Tampilkan di Portofolio Public')
                            ->default(false),

                        Forms\Components\DateTimePicker::make('diajukan_pada')
                            ->label('Diajukan Pada')
                            ->native(false)
                            ->seconds(false),

                        Forms\Components\DateTimePicker::make('disetujui_pada')
                            ->label('Disetujui Pada')
                            ->native(false)
                            ->seconds(false),

                        Forms\Components\DateTimePicker::make('ditolak_pada')
                            ->label('Ditolak Pada')
                            ->native(false)
                            ->seconds(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Mahasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategoriPrestasi.nama')
                    ->label('Kategori')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Prestasi')
                    ->searchable()
                    ->limit(45)
                    ->wrap(),

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

                Tables\Columns\TextColumn::make('tanggal_prestasi')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('diajukan_pada')
                    ->label('Diajukan')
                    ->dateTime('d M Y H:i')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('disetujui_pada')
                    ->label('Disetujui')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('ditolak_pada')
                    ->label('Ditolak')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'published' => 'Published',
                    ]),

                Tables\Filters\SelectFilter::make('tingkat')
                    ->label('Tingkat')
                    ->options([
                        'kampus' => 'Kampus',
                        'lokal' => 'Lokal',
                        'regional' => 'Regional',
                        'nasional' => 'Nasional',
                        'internasional' => 'Internasional',
                    ]),

                Tables\Filters\SelectFilter::make('kategori_prestasi_id')
                    ->label('Kategori')
                    ->relationship('kategoriPrestasi', 'nama'),

                Tables\Filters\TernaryFilter::make('ditampilkan')
                    ->label('Tampil di Portofolio')
                    ->trueLabel('Ditampilkan')
                    ->falseLabel('Tidak Ditampilkan')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->visible(fn (Prestasi $record): bool => $record->status === 'submitted')
                    ->requiresConfirmation()
                    ->modalHeading('Review Prestasi')
                    ->modalDescription('Status prestasi akan diubah menjadi Under Review.')
                    ->action(function (Prestasi $record): void {
                        $statusLama = $record->status;

                        $record->update([
                            'status' => 'under_review',
                            'ditampilkan' => false,
                        ]);

                        $record->riwayatStatusPrestasis()->create([
                            'diubah_oleh' => Auth::id(),
                            'status_lama' => $statusLama,
                            'status_baru' => 'under_review',
                            'catatan' => 'Prestasi sedang ditinjau oleh admin.',
                        ]);

                        Notification::make()
                            ->title('Status prestasi berhasil diubah menjadi Under Review')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Prestasi $record): bool => ! in_array($record->status, ['approved', 'published'], true))
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Prestasi')
                    ->modalDescription('Prestasi akan disetujui dan otomatis tampil di portofolio public.')
                    ->action(function (Prestasi $record): void {
                        $statusLama = $record->status;

                        $record->update([
                            'status' => 'approved',
                            'ditampilkan' => true,
                            'disetujui_pada' => now(),
                            'ditolak_pada' => null,
                        ]);

                        $record->validasiPrestasis()->create([
                            'validator_id' => Auth::id(),
                            'status' => 'approved',
                            'catatan' => 'Prestasi disetujui oleh admin.',
                            'divalidasi_pada' => now(),
                        ]);

                        $record->riwayatStatusPrestasis()->create([
                            'diubah_oleh' => Auth::id(),
                            'status_lama' => $statusLama,
                            'status_baru' => 'approved',
                            'catatan' => 'Prestasi disetujui oleh admin.',
                        ]);

                        Notification::make()
                            ->title('Prestasi berhasil disetujui')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Prestasi $record): bool => $record->status !== 'rejected')
                    ->form([
                        Forms\Components\Textarea::make('catatan')
                            ->label('Alasan Penolakan')
                            ->placeholder('Tuliskan alasan kenapa prestasi ditolak.')
                            ->required()
                            ->rows(4),
                    ])
                    ->modalHeading('Tolak Prestasi')
                    ->modalDescription('Prestasi akan ditolak dan tidak ditampilkan di portofolio public.')
                    ->action(function (Prestasi $record, array $data): void {
                        $statusLama = $record->status;

                        $record->update([
                            'status' => 'rejected',
                            'ditampilkan' => false,
                            'ditolak_pada' => now(),
                            'disetujui_pada' => null,
                        ]);

                        $record->validasiPrestasis()->create([
                            'validator_id' => Auth::id(),
                            'status' => 'rejected',
                            'catatan' => $data['catatan'],
                            'divalidasi_pada' => now(),
                        ]);

                        $record->riwayatStatusPrestasis()->create([
                            'diubah_oleh' => Auth::id(),
                            'status_lama' => $statusLama,
                            'status_baru' => 'rejected',
                            'catatan' => $data['catatan'],
                        ]);

                        Notification::make()
                            ->title('Prestasi berhasil ditolak')
                            ->danger()
                            ->send();
                    }),

                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-globe-alt')
                    ->color('primary')
                    ->visible(fn (Prestasi $record): bool => $record->status === 'approved' && ! $record->ditampilkan)
                    ->requiresConfirmation()
                    ->modalHeading('Publish Prestasi')
                    ->modalDescription('Prestasi approved akan ditampilkan di portofolio public.')
                    ->action(function (Prestasi $record): void {
                        $record->update([
                            'ditampilkan' => true,
                        ]);

                        Notification::make()
                            ->title('Prestasi berhasil ditampilkan di portofolio public')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->visible(fn (Prestasi $record): bool => in_array($record->status, ['approved', 'published'], true) && $record->ditampilkan)
                    ->requiresConfirmation()
                    ->modalHeading('Sembunyikan Prestasi')
                    ->modalDescription('Prestasi akan disembunyikan dari portofolio public.')
                    ->action(function (Prestasi $record): void {
                        $record->update([
                            'ditampilkan' => false,
                        ]);

                        Notification::make()
                            ->title('Prestasi berhasil disembunyikan dari portofolio public')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Admin\Resources\PrestasiResource\RelationManagers\FilePrestasisRelationManager::class,
            \App\Filament\Admin\Resources\PrestasiResource\RelationManagers\ValidasiPrestasisRelationManager::class,
            \App\Filament\Admin\Resources\PrestasiResource\RelationManagers\RiwayatStatusPrestasisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrestasis::route('/'),
            'create' => Pages\CreatePrestasi::route('/create'),
            'edit' => Pages\EditPrestasi::route('/{record}/edit'),
        ];
    }
}