<?php

namespace App\Filament\Resources\Archives\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
class ArchivesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable(),

                TextColumn::make('retention_years')
                    ->label('Masa Retensi (Tahun)')
                    ->sortable(),

                TextColumn::make('retention_end_date')
                    ->label('Berakhir Retensi')
                    ->date()
                    ->sortable(),

                TextColumn::make('retention_status')
                    ->badge()
                    ->color(fn ($record) =>
                        $record->retention_status === 'permanen'
                            ? 'warning'
                            : ($record->retention_end_date && $record->retention_end_date->isPast()
                                ? 'danger'
                                : 'success')
                    ),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                    DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
