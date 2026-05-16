<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicArchiveController extends Controller
{
    public function index(Request $request)
    {
        $query = Archive::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%')
                ->orWhere('kategori', 'like', '%' . $request->search . '%')
                ->orWhere('opd', 'like', '%' . $request->search . '%');
            });
        }

        if (request('tahun')) {
            $query->whereYear('created_at', request('tahun'));
        }

        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        if (request('opd')) {
            $query->where('opd', request('opd'));
        }

        $archives = $query
            ->where('approval_status', 'approved')
            ->latest()
            ->paginate(9);

        $tahunList = Archive::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->pluck('tahun');

        $kategoriList = Archive::distinct()->pluck('kategori');
        $opdList      = Archive::distinct()->pluck('opd');

        $totalArsip     = Archive::count();
        $arsipTahunIni  = Archive::whereYear('created_at', now()->year)->count();
        $jumlahKategori = Archive::distinct('kategori')->count('kategori');
        $jumlahOpd      = Archive::distinct('opd')->count('opd');

        return view('public.index', compact(
            'archives', 'tahunList', 'kategoriList', 'opdList',
            'totalArsip', 'arsipTahunIni', 'jumlahKategori', 'jumlahOpd'
        ));
    }

    public function show(Archive $archive)
    {
        if (in_array($archive->sifat_surat, ['rahasia', 'sangat_rahasia'])) {
            $token = request('token');
            if ($token !== env('ARSIP_RAHASIA_TOKEN')) {
                abort(403, 'Akses ditolak.');
            }
        }

        return view('public.show', compact('archive'));
    }

    public function download(Archive $archive)
    {
        if (in_array($archive->sifat_surat, ['rahasia', 'sangat_rahasia'])) {
            $token = request('token');
            if ($token !== env('ARSIP_RAHASIA_TOKEN')) {
                abort(403, 'Akses ditolak.');
            }
        }

        if (!$archive->file || !Storage::exists($archive->file)) {
            abort(404);
        }

        return Storage::download($archive->file, basename($archive->file));
    }

    public function verifyToken(Request $request)
    {
        $token     = $request->input('token');
        $archiveId = $request->input('archive_id');
        $action    = $request->input('action');

        if ($token !== env('ARSIP_RAHASIA_TOKEN')) {
            return response()->json(['success' => false, 'message' => 'Token salah.']);
        }

        $archive = Archive::findOrFail($archiveId);

        if ($action === 'download') {
            $url = route('public.download', $archive) . '?token=' . $token;
        } else {
            $url = route('public.show', $archive) . '?token=' . $token;
        }

        return response()->json(['success' => true, 'url' => $url]);
    }
}
