<?php

namespace App\Filament\Widgets;

use App\Models\Archive;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LatestArsip extends TableWidget
{
    protected static ?string $heading = 'Arsip Terbaru';
    protected int | string | array $columnSpan = 'full';

    protected static function isSuperAdmin(): bool
    {
        $user = Auth::user();

        return $user instanceof User && $user->hasRole('super_admin');
    }

    public function table(Table $table): Table
    {
         /** @var \Illuminate\Database\Eloquent\Builder $query */
         $query = Archive::query()
            ->forCurrentUser()
            ->latest()
            ->limit(5);

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->limit(35)
                    ->weight('semibold')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Petugas')
                    ->badge()
                    ->color('info')
                    ->visible(fn () => static::isSuperAdmin()),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('approval_status')
                    ->label('Approval')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn ($state) => match ($state) {
                        'approved' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                        'pending' => 'heroicon-o-clock',
                        default => null,
                    }),

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

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->since(),
            ]);
    }
}
