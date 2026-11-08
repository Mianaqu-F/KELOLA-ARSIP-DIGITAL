<?php
namespace App\Filament\Resources\Archives;

use App\Models\Archive;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Navigation\NavigationItem;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Components\TextEntry;

class ArchiveResource extends Resource
{
    protected static ?string $model = Archive::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Semua Arsip';
    protected static ?int $navigationSort = 1;

    /**
     * Helper terpusat untuk cek role super_admin.
     * Menggunakan instanceof agar Intelephense mengenali tipe User
     * dan tidak lagi menampilkan warning "Undefined method hasRole".
     */
    protected static function isSuperAdmin(): bool
    {
        $user = Auth::user();

        return $user instanceof User && $user->hasRole('super_admin');
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Arsip';
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        if (static::isSuperAdmin()) {
            return true;
        }

        return $record->user_id === Auth::id();
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        if (static::isSuperAdmin()) {
            return true;
        }

        return $record->user_id === Auth::id();
    }

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return false;
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Tambah Arsip')
                ->url(static::getUrl('create'))
                ->icon('heroicon-o-plus-circle')
                ->group('Arsip')
                ->sort(5)
                ->visible(fn () => Auth::check()),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('rejection_note_display')
                ->label('⚠️ Catatan Penolakan dari Admin')
                ->state(fn ($record) => $record?->rejection_note)
                ->visible(fn ($record) => $record && $record->approval_status === 'rejected')
                ->columnSpanFull(),

            TextInput::make('judul')
                ->required()
                ->maxLength(255),

            TextInput::make('nomor_dokumen')
                ->maxLength(255),

            Forms\Components\DatePicker::make('tanggal_surat')
                ->required(),

            Select::make('jenis_dokumen')
                ->options([
                    'Surat Masuk' => 'Surat Masuk',
                    'Surat Keluar' => 'Surat Keluar',
                    'Surat Edaran' => 'Surat Edaran',
                    'Surat Keputusan (SK)' => 'Surat Keputusan (SK)',
                    'Instruksi' => 'Instruksi',
                    'Nota Dinas' => 'Nota Dinas',
                    'Memorandum' => 'Memorandum',
                    'Undangan' => 'Undangan',
                    'Berita Acara' => 'Berita Acara',
                    'Laporan' => 'Laporan',
                    'Peraturan' => 'Peraturan',
                    'Pengumuman' => 'Pengumuman',
                    'Disposisi' => 'Disposisi',
                    'Rekomendasi' => 'Rekomendasi',
                    'Surat Tugas' => 'Surat Tugas',
                ])
                ->searchable()
                ->required()
                ->native(false),

            Select::make('sifat_surat')
                ->options([
                    'biasa' => 'Biasa',
                    'rahasia' => 'Rahasia',
                ])
                ->required()
                ->native(false),

            Select::make('kategori')
                ->options([
                    'Administrasi Umum' => 'Administrasi Umum',
                    'Tata Usaha' => 'Tata Usaha',
                    'Kepegawaian' => 'Kepegawaian',
                    'Keuangan' => 'Keuangan',
                    'Perencanaan & Anggaran' => 'Perencanaan & Anggaran',
                    'Aset / BMD' => 'Aset / BMD',
                    'Hukum & Peraturan' => 'Hukum & Peraturan',
                    'Pemerintahan' => 'Pemerintahan',
                    'Pembangunan' => 'Pembangunan',
                    'Pengadaan Barang & Jasa' => 'Pengadaan Barang & Jasa',
                    'Kerjasama' => 'Kerjasama',
                    'Pengawasan / Inspektorat' => 'Pengawasan / Inspektorat',
                    'Statistik & Data' => 'Statistik & Data',
                    'Pelaporan' => 'Pelaporan',
                    'Kearsipan' => 'Kearsipan',
                ])
                ->searchable()
                ->required()
                ->native(false),

            TextInput::make('opd')
                ->required(),

            TextInput::make('tahun')
                ->default(now()->year)
                ->disabled()
                ->dehydrated(),

            FileUpload::make('file')
                ->directory('arsip')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(2048)
                ->required()
                ->disk('public'),

            Forms\Components\Textarea::make('deskripsi'),

            Hidden::make('user_id')
                ->default(fn () => Auth::id())
                ->dehydrated(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Archive::query()->forCurrentUser())
            ->columns([
                TextColumn::make('judul')
                    ->searchable()
                    ->limit(35)
                    ->weight('semibold')
                    ->wrap(),

                TextColumn::make('nomor_dokumen')
                    ->label('Nomor')
                    ->searchable(),

                TextColumn::make('tanggal_surat')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('kategori')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('approval_status')
                    ->label('Approval')
                    ->badge()
                    ->icon(fn ($state) => match ($state) {
                        'approved' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                        'pending' => 'heroicon-o-clock',
                        default => null,
                    })
                    ->color(fn ($state) => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                        default => $state,
                    }),

                TextColumn::make('retention_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'aktif' => 'success',
                        'permanen' => 'warning',
                        'inaktif' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('file')
                    ->label('Dokumen')
                    ->formatStateUsing(fn () => '📄 Lihat File')
                    ->url(fn ($record) => route('admin.archives.preview', $record))
                    ->openUrlInNewTab()
                    ->color('primary'),

                TextColumn::make('user.name')
                    ->label('Petugas')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->visible(fn () => static::isSuperAdmin()),

                TextColumn::make('rejection_note')
                    ->label('Catatan Penolakan')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->rejection_note)
                    ->visible(fn () => true)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('jenis_dokumen')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sifat_surat')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('opd')
                    ->limit(20)
                    ->tooltip(fn ($record) => $record->opd)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tahun')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('retention_years')
                    ->label('Retensi')
                    ->formatStateUsing(fn ($state) => $state . ' Tahun')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('retention_end_date')
                    ->label('Berakhir')
                    ->date('d M Y')
                    ->color(fn ($record) =>
                        $record->retention_end_date && $record->retention_end_date->isPast()
                            ? 'danger' : 'success'
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('approval_status')
                    ->label('Status Approval')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),

                SelectFilter::make('kategori')
                    ->options([
                        'Administrasi Umum' => 'Administrasi Umum',
                        'Kepegawaian' => 'Kepegawaian',
                        'Keuangan' => 'Keuangan',
                        'Hukum & Peraturan' => 'Hukum & Peraturan',
                        'Kearsipan' => 'Kearsipan',
                    ]),

                SelectFilter::make('retention_status')
                    ->label('Status Retensi')
                    ->options([
                        'aktif' => 'Aktif',
                        'permanen' => 'Permanen',
                        'inaktif' => 'Inaktif',
                    ]),

                SelectFilter::make('tahun')
                    ->options(fn () =>
                        Archive::query()->distinct()->pluck('tahun', 'tahun')->toArray()
                    ),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) =>
                        static::isSuperAdmin() &&
                        $record->approval_status === 'pending'
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Arsip?')
                    ->modalDescription('Arsip ini akan dipublikasikan dan dapat dilihat secara global.')
                    ->action(function ($record) {
                        $record->update(['approval_status' => 'approved']);
                        Notification::make()
                            ->title('Arsip berhasil disetujui')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn ($record) =>
                        static::isSuperAdmin() &&
                        $record->approval_status === 'pending'
                    )
                    ->schema([
                        Textarea::make('rejection_note')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->placeholder('Tulis alasan penolakan...'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'approval_status' => 'rejected',
                            'rejection_note' => $data['rejection_note'],
                        ]);
                        Notification::make()
                            ->title('Arsip ditolak')
                            ->danger()
                            ->send();
                    }),

                EditAction::make()
                    ->visible(fn ($record) =>
                        static::isSuperAdmin() ||
                        $record->user_id === Auth::id()
                    ),

                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Arsip?')
                    ->modalDescription('Data yang dihapus tidak dapat dikembalikan.')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->visible(fn ($record) =>
                        static::isSuperAdmin() ||
                        $record->user_id === Auth::id()
                    ),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArchives::route('/'),
            'pending' => Pages\ApprovalArchive::route('/pending'),
            'approved' => Pages\ApprovedArchive::route('/approved'),
            'rejected' => Pages\RejectedArchive::route('/rejected'),
            'create' => Pages\CreateArchive::route('/create'),
            'edit' => Pages\EditArchive::route('/{record}/edit'),
        ];
    }
}
