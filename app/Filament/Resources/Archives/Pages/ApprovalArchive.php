<?php

namespace App\Filament\Resources\Archives\Pages;

use App\Filament\Resources\Archives\ArchiveResource;
use App\Models\Archive;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApprovalArchive extends ListRecords
{
    protected static string $resource = ArchiveResource::class;
    protected static ?int $navigationSort = 2;


    public static function getNavigationLabel(): string
    {
        return 'Menunggu Persetujuan';
    }

    public function getTitle(): string
    {
        return 'Menunggu Persetujuan';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Arsip';
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-clock';
    }

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return Auth::check();
    }

    public function table(Table $table): Table
    {
        $query = Archive::with('user')->where('approval_status', 'pending');
        $user = Auth::user();

        if (!($user instanceof \App\Models\User && $user->hasRole('super_admin'))) {
            $query->forCurrentUser();
        }

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->weight('semibold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Petugas')
                    ->badge()
                    ->color('info')
                    ->visible(function () {
                        $user = Auth::user();
                        return $user instanceof \App\Models\User && $user->hasRole('super_admin');
                    }),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('tanggal_surat')
                    ->label('Tanggal')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('approval_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending'  => 'Menunggu',
                        default    => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending'  => 'warning',
                        default    => 'gray',
                    })
                    ->icon(fn ($state) => match ($state) {
                        'approved' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                        'pending'  => 'heroicon-o-clock',
                        default    => null,
                    }),

                Tables\Columns\TextColumn::make('file')
                    ->label('Dokumen')
                    ->formatStateUsing(fn () => '📄 Lihat File')
                    ->url(fn ($record) => Storage::url($record->file))
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
                            ? 'danger' : 'success'
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) =>
                        Auth::user() instanceof \App\Models\User &&
                        Auth::user()->hasRole('super_admin') &&
                        $record->approval_status === 'pending'
                    )
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-o-check-circle')
                    ->modalIconColor('success')
                    ->modalHeading('Setujui Arsip Ini?')
                    ->modalDescription('Arsip akan dipublikasikan dan dapat diakses secara global. Tindakan ini tidak dapat dibatalkan.')
                    ->modalSubmitActionLabel('Ya, Setujui')
                    ->modalCancelActionLabel('Batal')
                    ->action(function ($record) {
                        $record->update(['approval_status' => 'approved']);
                        Notification::make()
                            ->title('Arsip Disetujui')
                            ->body('Arsip berhasil dipindahkan ke daftar disetujui.')
                            ->success()
                            ->duration(5000)
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) =>
                        Auth::user() instanceof \App\Models\User &&
                        Auth::user()->hasRole('super_admin') &&
                        $record->approval_status === 'pending'
                    )
                    ->modalIcon('heroicon-o-x-circle')
                    ->modalIconColor('danger')
                    ->modalHeading('Tolak Arsip Ini?')
                    ->modalDescription('Arsip akan ditolak dan petugas akan menerima notifikasi penolakan.')
                    ->modalSubmitActionLabel('Ya, Tolak')
                    ->modalCancelActionLabel('Batal')
                    ->schema([
                        Textarea::make('rejection_note')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->placeholder('Tulis alasan penolakan secara jelas...')
                            ->rows(4)
                            ->helperText('Catatan ini akan ditampilkan kepada petugas yang mengajukan arsip.'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'approval_status' => 'rejected',
                            'rejection_note'  => $data['rejection_note'],
                        ]);
                        Notification::make()
                            ->title('Arsip Ditolak')
                            ->body('Arsip telah ditolak dengan catatan penolakan.')
                            ->danger()
                            ->duration(5000)
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
