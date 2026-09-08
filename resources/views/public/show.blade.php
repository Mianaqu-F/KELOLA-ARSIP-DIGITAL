@extends('layouts.app')

@section('content')

<section class="detail-section">
    <div class="container">

        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb breadcrumb-modern">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.home') }}">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.home') }}#arsip">Daftar Arsip</a>
                </li>
                <li class="breadcrumb-item active">Detail Arsip</li>
            </ol>
        </nav>

        <div class="row g-4 align-items-start">

            <div class="col-lg-8">
                <div class="detail-card">

                    <div class="mb-4">
                        <span class="badge-portal mb-3 d-inline-block">
                            Portal Resmi Diskominfosantik
                        </span>
                        <h1 class="detail-title">
                            {{ $archive->judul }}
                        </h1>
                        <p style="font-size:13.5px;color:var(--text-muted);margin-top:10px;">
                            Dipublikasikan {{ optional($archive->created_at)->format('d F Y') }}
                        </p>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="row g-4">

                        <div class="col-sm-6">
                            <div class="detail-item">
                                <span class="detail-label">Nomor Dokumen</span>
                                <span class="detail-value">{{ $archive->nomor_dokumen ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="detail-item">
                                <span class="detail-label">Tanggal Arsip</span>
                                <span class="detail-value">{{ optional($archive->created_at)->format('d F Y') }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="detail-item">
                                <span class="detail-label">Kategori</span>
                                <span class="detail-value">{{ $archive->kategori ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="detail-item">
                                <span class="detail-label">OPD</span>
                                <span class="detail-value">{{ $archive->opd ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="detail-item">
                                <span class="detail-label">Klasifikasi</span>
                                @php
                                    $cls = $archive->sifat_surat ?? 'biasa';
                                    $clsColor = match($cls) {
                                        'rahasia'        => '#7f1d1d',
                                        default          => 'var(--teal-600)',
                                    };
                                @endphp
                                <span class="detail-value">
                                    <span class="detail-classification">
                                        <span class="detail-classification-dot" style="background:{{ $clsColor }};"></span>
                                        {{ ucfirst(str_replace('_', ' ', $cls)) }}
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="detail-item">
                                <span class="detail-label">Status Arsip</span>
                                <span class="detail-value status-public">
                                    ✓ &nbsp;Publik
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="detail-divider"></div>

                    @if($archive->file)
                    @php $fileUrl = asset('storage/' . $archive->file); @endphp

                    <div class="pdf-preview-wrapper">

                        <div class="pdf-preview-header">
                            <span class="pdf-preview-title">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                Preview Dokumen
                            </span>
                            <a href="{{ $fileUrl }}" target="_blank" class="pdf-preview-newtab">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                    <polyline points="15 3 21 3 21 9"/>
                                    <line x1="10" y1="14" x2="21" y2="3"/>
                                </svg>
                                Buka di tab baru
                            </a>
                        </div>

                        <div class="pdf-embed-container">
                            <iframe
                                src="{{ $fileUrl }}#toolbar=0&navpanes=0&scrollbar=1&view=FitH"
                                class="pdf-iframe"
                                title="Preview: {{ $archive->judul }}"
                                loading="lazy">
                                <div class="pdf-fallback">
                                    <svg width="40" height="40" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                    <p>Browser Anda tidak mendukung preview PDF.</p>
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn-download-modern">Buka Dokumen</a>
                                </div>
                            </iframe>
                        </div>

                    </div>
                    @endif

                    <div class="detail-divider"></div>

                    <div class="detail-footer">
                        <span class="detail-update">
                            Terakhir diperbarui:
                            {{ optional($archive->updated_at)->format('d F Y, H:i') }} WIB
                        </span>
                        <a href="{{ route('public.download', $archive) }}" class="btn btn-download-modern">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            Unduh Dokumen
                        </a>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">

                <div class="detail-sidebar-card mb-4">
                    <p class="detail-sidebar-title">Informasi Dokumen</p>

                    <div class="detail-sidebar-item">
                        <span class="detail-sidebar-icon">📄</span>
                        <div>
                            <span class="detail-sidebar-label">Format</span>
                            <span class="detail-sidebar-val">PDF / Dokumen Resmi</span>
                        </div>
                    </div>

                    <div class="detail-sidebar-item">
                        <span class="detail-sidebar-icon">🏛️</span>
                        <div>
                            <span class="detail-sidebar-label">Instansi</span>
                            <span class="detail-sidebar-val">{{ $archive->opd ?? 'Pemerintah Daerah' }}</span>
                        </div>
                    </div>

                    <div class="detail-sidebar-item">
                        <span class="detail-sidebar-icon">🔒</span>
                        <div>
                            <span class="detail-sidebar-label">Akses</span>
                            <span class="detail-sidebar-val detail-sidebar-val--public">Tersedia untuk Publik</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('public.home') }}#arsip" class="btn-back-arsip">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    Kembali ke Daftar Arsip
                </a>

            </div>

        </div>

    </div>
</section>

@endsection
