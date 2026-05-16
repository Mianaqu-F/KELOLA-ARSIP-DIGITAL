<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetentionRule extends Model
{
    protected $fillable = [
        'kategori',
        'jenis_dokumen',
        'retention_years',
        'final_action',
    ];
}

