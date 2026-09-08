@extends('layouts.app')

@section('content')

<section class="hero">
    <div class="hero-bar"></div>
    <div class="hero-content container">

        <span class="section-label mb-4 d-block" style="color:var(--teal-400);opacity:0.9;letter-spacing:2px;">
            🏛️ &nbsp; Portal Resmi Diskominfosantik
        </span>

        <h1>
            Sistem Informasi<br>Arsip Digital Terintegrasi
        </h1>

        <p>
            Portal resmi pengelolaan dan publikasi arsip Diskominfosantik
            untuk mendukung transparansi dan akses informasi publik secara
            mudah, cepat, dan terpercaya.
        </p>

        <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="#arsip" class="btn btn-primary">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Telusuri Arsip
            </a>
            <a href="#statistik" class="btn btn-outline">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="m7 16 4-4 4 4 4-4"/></svg>
                Lihat Statistik
            </a>
        </div>

    </div>
</section>

<section id="tentang" class="section-white">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                <span class="section-label">Tentang Sistem</span>

                <h2 class="section-title mb-4">
                    Arsip Digital untuk<br>Pemerintahan Terbuka
                </h2>

                <p class="section-subtitle mb-4">
                    Platform terintegrasi untuk pengelolaan, penyimpanan, dan
                    publikasi arsip resmi Diskominfosantik guna mendukung
                    keterbukaan informasi publik dan transparansi tata kelola.
                </p>

                <p class="section-subtitle">
                    Dirancang untuk memudahkan Pegawai, unit kerja, mitra, serta masyarakat
                    dalam mengakses dokumen arsip secara cepat,
                    akurat, dan aman.
                </p>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <span class="chip chip-teal">✓ &nbsp;Akses Publik</span>
                    <span class="chip chip-navy">✓ &nbsp;Terenkripsi</span>
                    <span class="chip chip-teal">✓ &nbsp;Real-time</span>
                </div>

            </div>

            <div class="col-lg-6">
                <div style="
                    background: var(--bg-subtle);
                    border: 1px solid var(--border);
                    border-radius: var(--radius-lg);
                    padding: 32px;
                ">
                    <p style="font-size:11px;font-weight:700;letter-spacing:1.6px;text-transform:uppercase;color:var(--teal-500);margin-bottom:20px;">
                        ⚡ Akses Cepat
                    </p>

                    <div class="d-grid gap-3">

                        <a href="#arsip" class="quick-link">
                            <span class="quick-link-icon" style="background:rgba(30,68,104,0.08);">📂</span>
                            <span class="quick-link-text">
                                <strong>Telusuri Arsip Publik</strong>
                                <small>Cari dokumen berdasarkan kategori & OPD</small>
                            </span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-light);flex-shrink:0;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                        <a href="#statistik" class="quick-link">
                            <span class="quick-link-icon" style="background:rgba(23,184,153,0.1);">📊</span>
                            <span class="quick-link-text">
                                <strong>Statistik Transparansi</strong>
                                <small>Data arsip per kategori dan tahun</small>
                            </span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-light);flex-shrink:0;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                        <a href="#" class="quick-link">
                            <span class="quick-link-icon" style="background:rgba(245,158,11,0.08);">🏛️</span>
                            <span class="quick-link-text">
                                <strong>Informasi PPID</strong>
                                <small>Pejabat Pengelola Informasi & Dokumentasi</small>
                            </span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-light);flex-shrink:0;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="statistik" class="section-light">
    <div class="container">

        <div class="text-center mb-5">
            <span class="section-label" style="text-align:center;">Transparansi Data</span>
            <h2 class="section-title" style="text-align:center;">Statistik Arsip</h2>
            <p class="section-subtitle mx-auto" style="text-align:center;">
                Data statistik per {{ now()->format('F Y') }}
            </p>
        </div>

        <div class="row g-4">

            <div class="col-lg-3 col-md-6">
                <div class="stat-box">
                    <span class="stat-icon">📁</span>
                    <h2>{{ $totalArsip }}</h2>
                    <p>Total Arsip</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-box">
                    <span class="stat-icon">📅</span>
                    <h2>{{ $arsipTahunIni }}</h2>
                    <p>Arsip Tahun Ini</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-box">
                    <span class="stat-icon">🗂️</span>
                    <h2>{{ $jumlahKategori }}</h2>
                    <p>Jumlah Kategori</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-box">
                    <span class="stat-icon">🏢</span>
                    <h2>{{ $jumlahOpd }}</h2>
                    <p>Jumlah OPD</p>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ===== SECTION ARSIP TERBARU ===== --}}
<section class="section-white">
    <div class="container">

        <div class="d-flex align-items-end justify-content-between mb-5 flex-wrap gap-3">
            <div>
                <span class="section-label">Terbaru</span>
                <h2 class="section-title mb-0">Arsip Terbaru</h2>
            </div>
            <a href="#arsip" class="btn btn-outline-light" style="font-size:13.5px;padding:9px 18px;">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="row g-4">
            @foreach($archives->take(3) as $archive)

            @php
                $badgeColorTerbaru = match($archive->sifat_surat ?? 'biasa') {
                    'rahasia'        => '#7f1d1d',
                    default          => 'var(--navy-600)',
                };
                $isRahasiaTerbaru = in_array($archive->sifat_surat ?? 'biasa', ['rahasia']);
            @endphp

            <div class="col-md-4">
                <div class="card h-100 d-flex flex-column">

                    {{-- Badge sifat surat --}}
                    <div class="mb-3">
                        <span style="font-size:11px;font-weight:700;letter-spacing:0.7px;text-transform:uppercase;padding:4px 12px;border-radius:999px;background:{{ $badgeColorTerbaru }};color:white;">
                            {{ str_replace('_', ' ', $archive->sifat_surat ?? 'Biasa') }}
                        </span>
                    </div>

                    <div class="grow">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span style="width:6px;height:6px;border-radius:50%;background:var(--teal-400);flex-shrink:0;"></span>
                            <span style="font-size:11.5px;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">
                                {{ optional($archive->created_at)->format('d F Y') }}
                            </span>
                        </div>

                        <h6 style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text-base);line-height:1.55;font-size:14.5px;margin-bottom:10px;">
                            {{ $archive->judul }}
                        </h6>

                        @if($archive->opd)
                        <p style="font-size:12.5px;color:var(--text-muted);">
                            {{ $archive->opd }}
                        </p>
                        @endif
                    </div>

                    {{-- ✅ FIX: Tombol dengan logika rahasia sama seperti section pencarian --}}
                    <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid var(--border);">

                        @if($isRahasiaTerbaru)

                            <button type="button"
                                    class="btn btn-outline-light grow"
                                    style="padding:9px 14px;font-size:13px;"
                                    onclick="bukaTokenModal({{ $archive->id }}, 'detail')">
                                🔒 Detail
                            </button>
                            <button type="button"
                                    class="btn btn-primary grow"
                                    style="padding:9px 14px;font-size:13px;"
                                    onclick="bukaTokenModal({{ $archive->id }}, 'download')">
                                🔒 Unduh
                            </button>

                        @else

                            <a href="{{ route('public.show', $archive) }}"
                               class="btn btn-outline-light grow"
                               style="padding:9px 14px;font-size:13px;">
                                Detail
                            </a>
                            <a href="{{ Storage::url($archive->file) }}"
                                target="_blank"
                                class="btn btn-primary grow"
                                style="padding:9px 14px;font-size:13px;">
                                    Unduh
                            </a>

                        @endif

                    </div>

                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ===== SECTION TELUSURI ARSIP PUBLIK ===== --}}
<section id="arsip" class="section-light">
    <div class="container">

        <div class="text-center mb-2">
            <span class="section-label" style="text-align:center;">Pencarian</span>
            <h2 class="section-title" style="text-align:center;">Telusuri Arsip Publik</h2>
            <p class="section-subtitle mx-auto" style="text-align:center;">
                Temukan dokumen arsip resmi yang Anda butuhkan
            </p>
        </div>

        <div class="search-section mt-5">
            <form method="GET">

                <div class="row justify-content-center mb-2">
                    <div class="col-lg-8 col-md-7">
                        <input type="text"
                               name="search"
                               placeholder="Cari judul, nomor arsip, atau kata kunci..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <button type="submit" class="btn btn-primary w-100" style="height:50px;">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                            Cari
                        </button>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-3">
                        <select name="tahun">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="opd">
                            <option value="">Semua OPD</option>
                            @foreach($opdList as $opd)
                                <option value="{{ $opd }}" {{ request('opd') == $opd ? 'selected' : '' }}>{{ $opd }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100" style="height:50px;">
                            Terapkan Filter
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="row g-4 mt-2">
            @forelse($archives as $archive)

            <div class="col-md-4">
                <div class="card h-100 d-flex flex-column">

                    @php
                        $badgeColor = match($archive->sifat_surat ?? 'biasa') {
                            'rahasia'        => '#7f1d1d',
                            default          => 'var(--navy-600)',
                        };
                        $isRahasia = in_array($archive->sifat_surat ?? 'biasa', ['rahasia']);
                    @endphp

                    <div class="mb-3">
                        <span style="font-size:11px;font-weight:700;letter-spacing:0.7px;text-transform:uppercase;padding:4px 12px;border-radius:999px;background:{{ $badgeColor }};color:white;">
                            {{ str_replace('_', ' ', $archive->sifat_surat ?? 'Biasa') }}
                        </span>
                    </div>

                    <div class="grow">
                        <h6 style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text-base);line-height:1.55;font-size:14.5px;margin-bottom:12px;">
                            {{ $archive->judul }}
                        </h6>
                        <p style="font-size:12.5px;color:var(--text-muted);margin-bottom:4px;">
                            📋 Nomor: {{ $archive->nomor_dokumen ?? '-' }}
                        </p>
                        <p style="font-size:12.5px;color:var(--text-muted);">
                            🏢 OPD: {{ $archive->opd ?? '-' }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid var(--border);">

                        @if($isRahasia)

                            <button type="button"
                                    class="btn btn-outline-light grow"
                                    style="padding:9px 14px;font-size:13px;"
                                    onclick="bukaTokenModal({{ $archive->id }}, 'detail')">
                                🔒 Detail
                            </button>
                            <button type="button"
                                    class="btn btn-primary grow"
                                    style="padding:9px 14px;font-size:13px;"
                                    onclick="bukaTokenModal({{ $archive->id }}, 'download')">
                                🔒 Unduh
                            </button>

                        @else

                            <a href="{{ route('public.show', $archive) }}"
                               class="btn btn-outline-light grow"
                               style="padding:9px 14px;font-size:13px;">
                                Detail
                            </a>
                            <a href="{{ route('public.download', $archive) }}"
                               class="btn btn-primary grow"
                               style="padding:9px 14px;font-size:13px;">
                                Unduh
                            </a>

                        @endif

                    </div>

                </div>
            </div>

            @empty
            <div class="col-12 text-center py-5">
                <div style="font-size:44px;margin-bottom:16px;opacity:0.4;">🔍</div>
                <h5 style="font-family:'Fraunces',serif;color:var(--navy-800);font-weight:700;margin-bottom:8px;">Arsip tidak ditemukan</h5>
                <p style="color:var(--text-muted);font-size:14.5px;">Coba ubah kata kunci atau filter pencarian Anda.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination dengan #arsip anchor --}}
        @if($archives->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            <nav class="d-flex align-items-center gap-2 flex-wrap justify-content-center">

                @php
                    $queryParams = request()->query();
                    $buildUrl = function(int $page) use ($queryParams): string {
                        $params = array_merge($queryParams, ['page' => $page]);
                        return url()->current() . '?' . http_build_query($params) . '#arsip';
                    };
                @endphp

                {{-- Tombol Sebelumnya --}}
                @if($archives->onFirstPage())
                    <span class="btn btn-outline-light"
                          style="padding:8px 18px;font-size:13px;opacity:0.4;cursor:not-allowed;">
                        ← Sebelumnya
                    </span>
                @else
                    <a href="{{ $buildUrl($archives->currentPage() - 1) }}"
                       class="btn btn-outline-light"
                       style="padding:8px 18px;font-size:13px;">
                        ← Sebelumnya
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @foreach($archives->getUrlRange(1, $archives->lastPage()) as $page => $url)
                    @if($page == $archives->currentPage())
                        <span class="btn btn-primary"
                              style="padding:8px 14px;font-size:13px;min-width:40px;text-align:center;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $buildUrl($page) }}"
                           class="btn btn-outline-light"
                           style="padding:8px 14px;font-size:13px;min-width:40px;text-align:center;">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Tombol Selanjutnya --}}
                @if($archives->hasMorePages())
                    <a href="{{ $buildUrl($archives->currentPage() + 1) }}"
                       class="btn btn-primary"
                       style="padding:8px 18px;font-size:13px;">
                        Selanjutnya →
                    </a>
                @else
                    <span class="btn btn-primary"
                          style="padding:8px 18px;font-size:13px;opacity:0.4;cursor:not-allowed;">
                        Selanjutnya →
                    </span>
                @endif

            </nav>
        </div>
        @endif

        <p class="text-center mt-4" style="font-size:12.5px;color:var(--text-muted);">
            Terakhir diperbarui: {{ now()->format('d F Y H:i') }} WIB
        </p>

    </div>
</section>

{{-- Modal Token Akses --}}
<div id="tokenModal" style="
    display:none;
    position:fixed;inset:0;z-index:9999;
    background:rgba(0,0,0,0.5);
    align-items:center;justify-content:center;
">
    <div style="
        background:white;
        border-radius:16px;
        padding:32px;
        width:100%;max-width:420px;
        margin:0 16px;
        box-shadow:0 20px 60px rgba(0,0,0,0.3);
    ">
        <div style="margin-bottom:20px;">
            <p style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--teal-500);margin-bottom:6px;">Dokumen Terbatas</p>
            <h5 style="font-family:'Fraunces',serif;font-weight:700;color:var(--navy-800);font-size:20px;margin:0;">
                Masukkan Token Akses
            </h5>
        </div>

        <p style="font-size:13.5px;color:var(--text-muted);margin-bottom:20px;">
            Dokumen ini bersifat rahasia. Masukkan token yang valid untuk melanjutkan.
        </p>

        <input type="password"
               id="tokenInput"
               placeholder="Token akses..."
               style="margin-bottom:8px;">

        <p id="tokenError" style="font-size:12.5px;color:#dc2626;display:none;margin-bottom:12px;">
            Token salah. Silakan coba lagi.
        </p>

        <div class="d-flex gap-2 mt-2">
            <button type="button"
                    onclick="tutupTokenModal()"
                    class="btn btn-outline-light grow"
                    style="padding:10px;">
                Batal
            </button>
            <button type="button"
                    onclick="submitToken()"
                    class="btn btn-primary grow"
                    style="padding:10px;">
                Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
    let _archiveId = null;
    let _action    = null;

    function bukaTokenModal(archiveId, action) {
        _archiveId = archiveId;
        _action    = action;
        document.getElementById('tokenInput').value = '';
        document.getElementById('tokenError').style.display = 'none';
        document.getElementById('tokenModal').style.display = 'flex';
    }

    function tutupTokenModal() {
        document.getElementById('tokenModal').style.display = 'none';
    }

    function submitToken() {
        const token = document.getElementById('tokenInput').value;

        fetch('{{ route('public.verifyToken') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                token:      token,
                archive_id: _archiveId,
                action:     _action
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                tutupTokenModal();
                window.location.href = data.url;
            } else {
                document.getElementById('tokenError').style.display = 'block';
            }
        });
    }

    document.getElementById('tokenInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') submitToken();
    });
</script>

@endsection
