<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Archive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    public function preview(Archive $archive)
    {
        if (!$archive->file || !Storage::exists($archive->file)) {
            abort(404);
        }

        $extension = pathinfo($archive->file, PATHINFO_EXTENSION);
        $namaFile = Str::slug($archive->judul) . '.' . $extension;

        return Storage::response($archive->file, $namaFile, [
            'Content-Disposition' => 'inline; filename="' . $namaFile . '"',
        ]);
    }
}
