<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $kategori
 * @property string $jenis_dokumen
 * @property int|null $retention_years
 * @property string $final_action
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereFinalAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereJenisDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereRetentionYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperRetentionRule
 */
class RetentionRule extends Model
{
    protected $fillable = [
        'kategori',
        'jenis_dokumen',
        'retention_years',
        'final_action',
    ];
}

