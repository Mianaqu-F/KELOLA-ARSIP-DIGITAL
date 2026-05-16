<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Support\Facades\Auth;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('Sistem Arsip Digital')
            ->login(\App\Filament\Auth\Login::class)
            ->resources([
                \App\Filament\Resources\Archives\ArchiveResource::class,
            ])
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->widgets([
                \App\Filament\Widgets\LatestArsip::class,
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\ArsipChart::class,
            ])
            ->navigationItems([
                NavigationItem::make('Menunggu Persetujuan')
                    ->url('/admin/archives/pending')
                    ->icon('heroicon-o-clock')
                    ->group('Arsip')
                    ->sort(2)
                    ->visible(fn () => Auth::check() && Auth::user()->hasRole('super_admin')),

                NavigationItem::make('Menunggu Persetujuan')
                    ->url('/admin/archives/pending')
                    ->icon('heroicon-o-clock')
                    ->group('Arsip')
                    ->sort(2)
                    ->visible(fn () => Auth::check() && Auth::user()->hasRole('petugas')),

                NavigationItem::make('Disetujui')
                    ->url('/admin/archives/approved')
                    ->icon('heroicon-o-check-circle')
                    ->group('Arsip')
                    ->sort(3),

                NavigationItem::make('Ditolak')
                    ->url('/admin/archives/rejected')
                    ->icon('heroicon-o-x-circle')
                    ->group('Arsip')
                    ->sort(4),

                NavigationItem::make('Tambah Arsip')
                    ->url('/admin/archives/create')
                    ->icon('heroicon-o-plus-circle')
                    ->group('Arsip')
                    ->sort(1)
                    ->visible(fn () => Auth::check()),
            ])
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
