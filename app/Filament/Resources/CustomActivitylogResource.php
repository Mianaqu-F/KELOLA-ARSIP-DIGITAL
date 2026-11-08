<?php

namespace App\Filament\Resources;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rmsramos\Activitylog\Resources\Activitylog\ActivitylogResource;

class CustomActivitylogResource extends ActivitylogResource
{
    public static function table(Table $table): Table
    {
        return parent::table($table)
            ->columns([

                TextColumn::make('event')
                    ->label(__('activitylog::tables.columns.event.label'))
                    ->formatStateUsing(fn ($state) => $state ? ucwords(__('activitylog::action.event.' . $state)) : '-')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'draft'    => 'gray',
                        'updated'  => 'warning',
                        'created'  => 'success',
                        'deleted'  => 'danger',
                        'restored' => 'info',
                        default    => 'primary',
                    })
                    ->searchable(),

                static::getSubjectTypeColumnComponent(),
                static::getCauserNameColumnComponent(),
                static::getPropertiesColumnComponent(),

                TextColumn::make('created_at')
                    ->label(__('activitylog::tables.columns.created_at.label'))
                    ->dateTime(),
            ]);
    }

    public static function getSubjectTypeColumnComponent(): Column
    {
        return TextColumn::make('subject_type')
            ->label('Data')
            ->formatStateUsing(function ($state, $record) {
                if (!$state) return '-';

                $modelName = class_basename($state) === 'Archive' ? 'Arsip' : class_basename($state);

                if ($record->subject) {
                    $judul = $record->subject->judul ?? $record->subject_id;
                    return "{$modelName}: {$judul}";
                }

                return "{$modelName} #{$record->subject_id} (dihapus)";
            })
            ->searchable();
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ListActivitylog::route('/'),
        ];
    }
}
