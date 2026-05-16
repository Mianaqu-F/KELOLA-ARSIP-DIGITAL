<?php

namespace App\Observers;

use App\Models\Archive;
use App\Models\RetentionRule;
use Carbon\Carbon;

class ArchiveObserver
{
    /**
     * Handle the Archive "created" event.
     */
    public function creating(Archive $archive)
    {
        $rule = RetentionRule::where('kategori', $archive->kategori)
            ->where('jenis_dokumen', $archive->jenis_dokumen)
            ->first();

        if (!$rule) {
            return;
        }

        if ($rule->is_permanent) {
            $archive->retention_status = 'permanen';
            $archive->retention_end_date = null;
            $archive->retention_years = null;
            $archive->final_action = 'permanen';
            return;
        }

        $archive->retention_years = $rule->retention_years;

        $archive->retention_end_date = Carbon::parse($archive->tanggal_surat)
            ->addYears($rule->retention_years);

        $archive->retention_status = 'aktif';
        $archive->final_action = $rule->final_action;
    }

    /**
     * Handle the Archive "updated" event.
     */
    public function updated(Archive $archive): void
    {
        //
    }

    /**
     * Handle the Archive "deleted" event.
     */
    public function deleted(Archive $archive): void
    {
        //
    }

    /**
     * Handle the Archive "restored" event.
     */
    public function restored(Archive $archive): void
    {
        //
    }

    /**
     * Handle the Archive "force deleted" event.
     */
    public function forceDeleted(Archive $archive): void
    {
        //
    }
}
