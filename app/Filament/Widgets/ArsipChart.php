<?php

namespace App\Filament\Widgets;

use App\Models\Archive;
use Filament\Widgets\ChartWidget;

class ArsipChart extends ChartWidget
{
    protected ?string $heading = 'Arsip per Bulan';

    protected function getData(): array
    {
        $year = now()->year;

        $data = Archive::query()
            ->forCurrentUser()
            ->whereYear('tanggal_surat', $year)
            ->selectRaw('MONTH(tanggal_surat) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $months = collect(range(1, 12));

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Arsip',
                    'data' => $months->map(fn ($month) => $data[$month] ?? 0),
                    'borderColor' => '#22d3ee',
                    'backgroundColor' => 'rgba(34,211,238,0.15)',
                    'tension' => 0.4,
                    'fill' => true,
                    'borderWidth' => 3,
                    'pointBackgroundColor' => '#22d3ee',
                    'pointBorderColor' => '#22d3ee',
                    'pointRadius' => 0,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $months->map(fn ($month) => date('M', mktime(0, 0, 0, $month, 1))),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
