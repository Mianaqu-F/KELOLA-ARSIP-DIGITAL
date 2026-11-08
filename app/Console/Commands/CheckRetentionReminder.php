<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Archive;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

class CheckRetentionReminder extends Command
{
    protected $signature = 'app:check-retention-reminder';

    protected $description = 'Kirim notifikasi ke admin untuk arsip yang mendekati masa retensi';

    public function handle()
    {

        $archives = Archive::whereNotNull('retention_end_date')
            ->where('retention_status', 'aktif')
            ->whereBetween('retention_end_date', [Carbon::now(), Carbon::now()->addMonths(3)])
            ->get();

        if ($archives->isEmpty()) {
            $this->info('Tidak ada arsip yang mendekati masa retensi.');
            return;
        }

        $admins = User::role('super_admin')->get();

        foreach ($admins as $admin) {
            Notification::make()
                ->title('Arsip Mendekati Masa Retensi')
                ->body($archives->count() . ' arsip akan habis masa retensinya dalam 3 bulan ke depan.')
                ->icon('heroicon-o-clock')
                ->iconColor('warning')
                ->actions([
                    \Filament\Actions\Action::make('lihat')
                        ->label('Lihat Arsip')
                        ->url('/admin/archives'),
                ])
                ->sendToDatabase($admin);
        }

        Artisan::command('inspire', function () {
            $this->comment(Inspiring::quote());
        })->purpose('Display an inspiring quote');

        Schedule::command('app:check-archive-retention')
            ->daily();

        Schedule::command('app:check-retention-reminder')
            ->daily();

        $this->info($archives->count() . ' arsip mendekati retensi. Notifikasi terkirim ke ' . $admins->count() . ' admin.');
    }
}
