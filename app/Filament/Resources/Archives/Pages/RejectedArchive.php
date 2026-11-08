<?php

namespace App\Filament\Resources\Archives\Pages;

use App\Filament\Resources\Archives\ArchiveResource;
use App\Models\Archive;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class RejectedArchive extends ListRecords
{
    protected static string $resource = ArchiveResource::class;
    protected static ?string $title = 'Arsip Ditolak';
    protected static ?string $navigationLabel = 'Ditolak';
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return 'Arsip';
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-x-circle';
    }

    public function table(Table $table): Table
    {
        $query = Archive::with('user')->where('approval_status', 'rejected');
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

                Tables\Columns\TextColumn::make('rejection_note')
                    ->label('Catatan Penolakan')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->rejection_note)
                    ->color('danger')
                    ->icon('heroicon-o-exclamation-circle'),

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
                    ->color(fn ($record) => $record->retention_end_date && $record->retention_end_date->isPast() ? 'danger' : 'success')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make()
                    ->visible(fn ($record) => $record->user_id === Auth::id()),

                \Filament\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->visible(function () {
                        $user = Auth::user();
                        return $user instanceof \App\Models\User && $user->hasRole('super_admin');
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
