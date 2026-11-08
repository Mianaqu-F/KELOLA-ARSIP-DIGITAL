<?php

namespace App\Filament\Resources\Archives\Pages;

use App\Filament\Resources\Archives\ArchiveResource;
use App\Models\Archive;
use App\Models\User;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\DeleteAction;

class ApprovedArchive extends ListRecords
{
    protected static string $resource = ArchiveResource::class;
    protected static ?string $title = 'Disetujui';
    protected static ?string $navigationLabel = 'Disetujui';
    protected static ?int $navigationSort = 3;

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

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-check-circle';
    }

    // Menu hanya muncul untuk super admin
    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return static::isSuperAdmin();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Archive::with('user')
                    ->where('approval_status', 'approved')
                    ->when(
                        !static::isSuperAdmin(),
                        fn ($query) => $query->where('user_id', Auth::id())
                    )
            )
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->weight('semibold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Petugas')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('tanggal_surat')
                    ->label('Tanggal')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('retention_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'aktif' => 'success',
                        'permanen' => 'warning',
                        'inaktif' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('file')
                    ->label('Dokumen')
                    ->formatStateUsing(fn () => '📄 Lihat File')
                    ->url(fn ($record) => route('admin.archives.preview', $record))
                    ->openUrlInNewTab()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('jenis_dokumen')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('sifat_surat')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('opd')
                    ->limit(20)
                    ->tooltip(fn ($record) => $record->opd)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('tahun')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('retention_years')
                    ->label('Retensi')
                    ->formatStateUsing(fn ($state) => $state . ' Tahun')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('retention_end_date')
                    ->label('Berakhir')
                    ->date('d M Y')
                    ->color(fn ($record) =>
                        $record->retention_end_date && $record->retention_end_date->isPast()
                            ? 'danger'
                            : 'success'
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Arsip?')
                    ->modalDescription('Data yang dihapus tidak dapat dikembalikan.')
                    ->visible(fn () => static::isSuperAdmin()),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
