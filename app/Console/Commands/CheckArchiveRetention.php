<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Archive;
use Carbon\Carbon;

class CheckArchiveRetention extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-archive-retention';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Archive::whereNotNull('retention_end_date')
            ->where('retention_status', 'aktif')
            ->where('retention_end_date', '<', Carbon::now())
            ->update(['retention_status' => 'inaktif']);
    }
}
