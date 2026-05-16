<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RetentionRule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Archive extends Model
{
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }
    
    use SoftDeletes;

    protected $fillable = [
        'judul',
        'nomor_dokumen',
        'tanggal_surat',
        'jenis_dokumen',
        'sifat_surat',
        'kategori',
        'opd',
        'tahun',
        'file',
        'file_size',
        'file_type',
        'deskripsi',
        'user_id',
        'retention_years',
        'retention_status',
        'retention_end_date',
        'final_action',
        'approval_status',
        'rejection_note',
    ];

    protected static function booted()
    {
        static::creating(function ($archive) {

            $rule = RetentionRule::where('kategori', trim($archive->kategori))
                ->where('jenis_dokumen', trim($archive->jenis_dokumen))
                ->first();

            if (!$rule) {
                throw new \Exception(
                    'Retention rule tidak ditemukan untuk: ' .
                    $archive->kategori . ' - ' .
                    $archive->jenis_dokumen
                );
            }

            $archive->retention_years = $rule->retention_years;
            $archive->final_action = $rule->final_action;

            if ($rule->final_action === 'permanen') {
                $archive->retention_status = 'permanen';
                $archive->retention_end_date = null;
            } else {
                $archive->retention_end_date = Carbon::parse($archive->tanggal_surat)
                    ->addYears($rule->retention_years);

                $archive->retention_status = 'aktif';
            }

            $archive->approval_status = $archive->approval_status ?? 'pending';

            if (Auth::check() && Auth::user()->hasRole('super_admin')) {
                $archive->approval_status = 'approved';
            } else {
                $archive->approval_status = $archive->approval_status ?? 'pending';
            }
        });
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'retention_end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForCurrentUser(Builder $query): Builder
    {
        if (Auth::user()->hasRole('super_admin')) {
            return $query;
        }

        return $query->where('user_id', Auth::id());
    }
}
