<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property int $id
 * @property string $judul
 * @property string|null $nomor_dokumen
 * @property string $tanggal_surat
 * @property string $jenis_dokumen
 * @property string $sifat_surat
 * @property string $kategori
 * @property string $opd
 * @property string $tahun
 * @property string $file
 * @property int|null $file_size
 * @property string|null $file_type
 * @property string|null $deskripsi
 * @property int $user_id
 * @property int|null $retention_years
 * @property string|null $final_action
 * @property \Illuminate\Support\Carbon|null $retention_end_date
 * @property string $retention_status
 * @property string $approval_status
 * @property string|null $rejection_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User $user
 * @method static Builder<static>|Archive approved()
 * @method static Builder<static>|Archive forCurrentUser()
 * @method static Builder<static>|Archive newModelQuery()
 * @method static Builder<static>|Archive newQuery()
 * @method static Builder<static>|Archive onlyTrashed()
 * @method static Builder<static>|Archive query()
 * @method static Builder<static>|Archive whereApprovalStatus($value)
 * @method static Builder<static>|Archive whereCreatedAt($value)
 * @method static Builder<static>|Archive whereDeletedAt($value)
 * @method static Builder<static>|Archive whereDeskripsi($value)
 * @method static Builder<static>|Archive whereFile($value)
 * @method static Builder<static>|Archive whereFileSize($value)
 * @method static Builder<static>|Archive whereFileType($value)
 * @method static Builder<static>|Archive whereFinalAction($value)
 * @method static Builder<static>|Archive whereId($value)
 * @method static Builder<static>|Archive whereJenisDokumen($value)
 * @method static Builder<static>|Archive whereJudul($value)
 * @method static Builder<static>|Archive whereKategori($value)
 * @method static Builder<static>|Archive whereNomorDokumen($value)
 * @method static Builder<static>|Archive whereOpd($value)
 * @method static Builder<static>|Archive whereRejectionNote($value)
 * @method static Builder<static>|Archive whereRetentionEndDate($value)
 * @method static Builder<static>|Archive whereRetentionStatus($value)
 * @method static Builder<static>|Archive whereRetentionYears($value)
 * @method static Builder<static>|Archive whereSifatSurat($value)
 * @method static Builder<static>|Archive whereTahun($value)
 * @method static Builder<static>|Archive whereTanggalSurat($value)
 * @method static Builder<static>|Archive whereUpdatedAt($value)
 * @method static Builder<static>|Archive whereUserId($value)
 * @method static Builder<static>|Archive withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Archive withoutTrashed()
 */
class Archive extends Model
{
    use SoftDeletes, LogsActivity;

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

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'retention_end_date' => 'datetime',
    ];

    public function scopeApproved(Builder $query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForCurrentUser(Builder $query): Builder
    {
        $user = Auth::user();

        if ($user instanceof User && $user->hasRole('super_admin')) {
            return $query;
        }

        return $query->where('user_id', Auth::id());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'approval_status', 'retention_status', 'rejection_note'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
