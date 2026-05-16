<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ArsipChart;
use App\Filament\Widgets\LatestArsip;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected int $columns = 1;

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
            LatestArsip::class,
            StatsOverview::class,
            ArsipChart::class,
        ];
    }
}
