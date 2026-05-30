<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PrestasiResource\Pages;
use App\Models\Prestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PrestasiResource extends Resource
{
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'E-Portofolio';

    protected static ?string $navigationLabel = 'Prestasi Mahasiswa';

    protected static ?string $modelLabel = 'Prestasi Mahasiswa';

    protected static ?string $pluralModelLabel = 'Prestasi Mahasiswa';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Prestasi')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Mahasiswa')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('kategori_prestasi_id')
                            ->label('Kategori Prestasi')
                            ->relationship('kategoriPrestasi', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Prestasi')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('penyelenggara')
                            ->label('Penyelenggara')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('tingkat')
                            ->label('Tingkat')
                            ->options([
                                'kampus' => 'Kampus',
                                'regional' => 'Regional',
                                'nasional' => 'Nasional',
                                'internasional' => 'Internasional',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('jenis_prestasi')
                            ->label('Jenis Prestasi')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('tanggal_prestasi')
                            ->label('Tanggal Prestasi')
                            ->required()
                            ->native(false),
                    ]),

                Forms\Components\Section::make('Status Prestasi')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'submitted' => 'Submitted',
                                'under_review' => 'Under Review',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->default('submitted')
                            ->required(),

                        Forms\Components\Toggle::make('ditampilkan')
                            ->label('Tampilkan ke Public')
                            ->default(false),

                        Forms\Components\DateTimePicker::make('diajukan_pada')
                            ->label('Diajukan Pada')
                            ->seconds(false)
                            ->native(false)
                            ->default(now()),

                        Forms\Components\DateTimePicker::make('disetujui_pada')
                            ->label('Disetujui Pada')
                            ->seconds(false)
                            ->native(false),

                        Forms\Components\DateTimePicker::make('ditolak_pada')
                            ->label('Ditolak Pada')
                            ->seconds(false)
                            ->native(false),

                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('kategoriPrestasi.nama')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Prestasi')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(45),

                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'kampus' => 'Kampus',
                        'regional' => 'Regional',
                        'nasional' => 'Nasional',
                        'internasional' => 'Internasional',
                        default => ucfirst((string) $state),
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'kampus' => 'gray',
                        'regional' => 'warning',
                        'nasional' => 'success',
                        'internasional' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'submitted' => 'Submitted',
                        'under_review' => 'Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        default => ucfirst((string) $state),
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'submitted' => 'warning',
                        'under_review' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('ditampilkan')
                    ->label('Public')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_prestasi')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('diajukan_pada')
                    ->label('Diajukan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('-'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('tingkat')
                    ->label('Tingkat')
                    ->options([
                        'kampus' => 'Kampus',
                        'regional' => 'Regional',
                        'nasional' => 'Nasional',
                        'internasional' => 'Internasional',
                    ]),

                Tables\Filters\TernaryFilter::make('ditampilkan')
                    ->label('Public'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Prestasi')
                    ->modalDescription('Prestasi akan disetujui dan dapat ditampilkan pada halaman public.')
                    ->visible(fn (Prestasi $record): bool => in_array($record->status, ['submitted', 'under_review'], true))
                    ->action(function (Prestasi $record): void {
                        $record->update([
                            'status' => 'approved',
                            'ditampilkan' => true,
                            'disetujui_pada' => now(),
                            'ditolak_pada' => null,
                        ]);

                        Notification::make()
                            ->title('Prestasi berhasil di-approve')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Prestasi')
                    ->modalDescription('Prestasi akan ditolak dan tidak ditampilkan pada halaman public.')
                    ->visible(fn (Prestasi $record): bool => in_array($record->status, ['submitted', 'under_review'], true))
                    ->action(function (Prestasi $record): void {
                        $record->update([
                            'status' => 'rejected',
                            'ditampilkan' => false,
                            'ditolak_pada' => now(),
                            'disetujui_pada' => null,
                        ]);

                        Notification::make()
                            ->title('Prestasi berhasil di-reject')
                            ->danger()
                            ->send();
                    }),

                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Publish Prestasi')
                    ->modalDescription('Prestasi akan ditampilkan pada portofolio public.')
                    ->visible(fn (Prestasi $record): bool => $record->status === 'approved' && ! $record->ditampilkan)
                    ->action(function (Prestasi $record): void {
                        $record->update([
                            'ditampilkan' => true,
                        ]);

                        Notification::make()
                            ->title('Prestasi berhasil dipublish')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading('Unpublish Prestasi')
                    ->modalDescription('Prestasi akan disembunyikan dari portofolio public.')
                    ->visible(fn (Prestasi $record): bool => $record->status === 'approved' && $record->ditampilkan)
                    ->action(function (Prestasi $record): void {
                        $record->update([
                            'ditampilkan' => false,
                        ]);

                        Notification::make()
                            ->title('Prestasi berhasil diunpublish')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-trophy')
            ->emptyStateHeading('Belum ada data prestasi')
            ->emptyStateDescription('Data prestasi mahasiswa akan tampil di sini.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Prestasi'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'user',
                'kategoriPrestasi',
            ]);
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