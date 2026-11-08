<?php

namespace App\Observers;

use App\Models\Archive;
use App\Models\RetentionRule;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();
        $isSuperAdmin = $user instanceof User && $user->hasRole('super_admin');
        $archive->approval_status = $isSuperAdmin ? 'approved' : ($archive->approval_status ?? 'pending');

        if ($rule->is_permanent) {
            $archive->retention_status = $isSuperAdmin ? 'aktif' : 'inaktif';
            $archive->retention_end_date = null;
            $archive->retention_years = null;
            $archive->final_action = 'permanen';
            return;
        }

        $archive->retention_years = $rule->retention_years;

        $archive->retention_end_date = Carbon::parse($archive->tanggal_surat)
            ->addYears($rule->retention_years);

        $archive->retention_status = $isSuperAdmin ? 'aktif' : 'inaktif';
        $archive->final_action = $rule->final_action;
    }

    public function saving(Archive $archive)
    {
        if ($archive->isDirty('approval_status') && $archive->retention_status !== 'permanen') {
            if ($archive->approval_status === 'approved') {
                $archive->retention_status = 'aktif';
            } elseif ($archive->approval_status === 'rejected') {
                $archive->retention_status = 'inaktif';
            } elseif ($archive->approval_status === 'pending') {
                $archive->retention_status = 'inaktif';
            }
        }
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
