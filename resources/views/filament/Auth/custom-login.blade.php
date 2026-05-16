<x-filament-panels::page.simple>

    @vite('resources/css/filament-login.css')

    {{-- BG Batik SVG --}}
    <svg xmlns="http://www.w3.org/2000/svg" style="position:fixed;inset:0;width:100%;height:100%;z-index:0;pointer-events:none;">
        <defs>
            <linearGradient id="gbg" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#ddf0ec"/>
                <stop offset="55%" stop-color="#f5fcfb"/>
                <stop offset="100%" stop-color="#d6ece7"/>
            </linearGradient>
            <pattern id="bp" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                <path d="M0,80 Q20,60 40,40 Q60,20 80,0" stroke="#1a7a6e" stroke-width="1" fill="none" opacity="0.08"/>
                <path d="M-10,70 Q10,50 30,30 Q50,10 70,-10" stroke="#1a7a6e" stroke-width="0.5" fill="none" opacity="0.05"/>
                <path d="M10,90 Q30,70 50,50 Q70,30 90,10" stroke="#1a7a6e" stroke-width="0.5" fill="none" opacity="0.05"/>
                <path d="M40,40 L44,44 L40,48 L36,44 Z" stroke="#2d9e8f" stroke-width="0.7" fill="none" opacity="0.09"/>
                <circle cx="20" cy="20" r="1" fill="#1a7a6e" opacity="0.08"/>
                <circle cx="60" cy="60" r="1" fill="#1a7a6e" opacity="0.08"/>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#gbg)"/>
        <rect width="100%" height="100%" fill="url(#bp)"/>
        <circle cx="0" cy="0" r="300" fill="none" stroke="#1a7a6e" stroke-width="65" opacity="0.015"/>
        <circle cx="100%" cy="100%" r="270" fill="none" stroke="#1a7a6e" stroke-width="55" opacity="0.015"/>
    </svg>

    <div class="login-page">
        <div class="login-card">

            {{-- Header --}}
            <div class="login-header">
                <div class="login-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div class="login-title">Selamat Datang</div>
                <div class="login-subtitle">Sistem Arsip Digital Pemerintah Daerah</div>
            </div>

            {{-- Divider --}}
            <div class="login-divider"><span>Masuk ke Akun Anda</span></div>

            {{-- Form --}}
            <form wire:submit.prevent="authenticate">
                {{ $this->form }}
                <button type="submit" class="login-btn">
                    <span wire:loading.remove>Masuk ke Sistem</span>
                    <span wire:loading style="display:none">Memproses...</span>
                </button>
            </form>

            {{-- Footer --}}
            <div class="login-footer">
                Sistem Arsip Digital &copy; {{ date('Y') }} &nbsp;·&nbsp; Pemerintah Daerah
            </div>

        </div>
    </div>

</x-filament-panels::page.simple>
