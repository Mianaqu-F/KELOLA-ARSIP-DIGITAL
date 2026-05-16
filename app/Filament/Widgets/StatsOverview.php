<?php

namespace App\Filament\Widgets;

use App\Models\Archive;
use Filament\Widgets\StatsOverviewWidget as Widget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends Widget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
            return [
            Stat::make('Total Arsip', Archive::query()->forCurrentUser()->count())
                ->description('Seluruh arsip tersimpan')
                ->icon('heroicon-o-archive-box')
                ->color('primary'),

            Stat::make('Arsip Aktif',
                Archive::query()->forCurrentUser()->where('retention_status', 'aktif')->count()
            )
                ->description('Masih dalam masa retensi')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Arsip Kadaluarsa',
                Archive::query()->forCurrentUser()
                    ->whereDate('retention_end_date', '<', now())
                    ->where('retention_status', '!=', 'permanen')
                    ->count()
            )
                ->description('Sudah melewati retensi')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Mendekati Retensi',
                Archive::query()->forCurrentUser()
                    ->whereBetween('retention_end_date', [now(), now()->addMonths(3)])
                    ->count()
            )
                ->description('Akan habis dalam 3 bulan')
                ->icon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}
