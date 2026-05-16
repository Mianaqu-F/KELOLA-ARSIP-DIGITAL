<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Arsip Digital Diskominfosantik</title>
    <link rel="icon" type="image/png" href="https://share-storage.bekasikab.go.id/public/logo-diskominfosantik-1.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modern-ui.css') }}">

    <style>
        .navbar-modern {
            background: linear-gradient(90deg, #0B1F2E 0%, #112840 100%);
            padding: 0;
            border-bottom: 1.5px solid rgba(14, 124, 110, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050;
            transition: all 0.3s ease;
        }

        .navbar-modern.scrolled {
            background: rgba(9, 20, 32, 0.97);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom-color: rgba(14, 124, 110, 0.35);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
        }

        .navbar-modern.scrolled .container {
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .brand-modern {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-logo-wrap {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(23, 184, 153, 0.12);
            border: 1px solid rgba(23, 184, 153, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .brand-modern:hover .brand-logo-wrap {
            background: rgba(23, 184, 153, 0.2);
            border-color: rgba(23, 184, 153, 0.4);
            transform: rotate(-6deg) scale(1.08);
        }

        .brand-logo {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .brand-subtitle {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #17B899;
            opacity: 0.9;
        }

        .brand-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.2px;
        }

        .navbar-modern .nav-link {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: rgba(255, 255, 255, 0.6) !important;
            font-weight: 500;
            font-size: 13.5px;
            padding: 7px 13px !important;
            border-radius: 8px;
            position: relative;
            transition: all 0.25s ease;
            letter-spacing: 0.1px;
        }

        .navbar-modern .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.07);
        }

        .navbar-modern .nav-link.active {
            color: #fff !important;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.07);
        }

        .navbar-modern .nav-link.active::after {
            content: "";
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #17B899;
        }

        .nav-divider {
            width: 1px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 6px;
            align-self: center;
        }

        .navbar-toggler {
            padding: 7px 11px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.07) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            transition: all 0.25s ease;
        }

        .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.12) !important;
        }

        .navbar-toggler-icon {
            filter: invert(1);
            width: 18px;
            height: 18px;
        }

        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(9, 20, 32, 0.98);
                border-radius: 14px;
                padding: 14px;
                margin-top: 10px;
                border: 1px solid rgba(255, 255, 255, 0.07);
                box-shadow: 0 20px 56px rgba(0, 0, 0, 0.4);
            }

            .navbar-modern .nav-link {
                padding: 10px 14px !important;
                border-radius: 10px;
            }

            .nav-divider {
                width: 100%;
                height: 1px;
                margin: 6px 0;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-modern" id="mainNavbar">
    <div class="container">

        <a class="navbar-brand brand-modern" href="{{ route('public.home') }}">
            <div class="brand-logo-wrap">
                <img src="https://share-storage.bekasikab.go.id/public/logo-diskominfosantik-1.png"
                     alt="Logo" class="brand-logo">
            </div>
            <div class="brand-text">
                <span class="brand-subtitle">Portal Resmi</span>
                <span class="brand-title">Sistem Arsip Digital Diskominfosantik</span>
            </div>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-lg-center gap-lg-1">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}"
                       href="{{ route('public.home') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tentang">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#statistik">Statistik</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.home') }}#arsip">
                        Pencarian Arsip
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>

@yield('content')

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const navbar = document.getElementById('mainNavbar');

    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    const navLinks = document.querySelectorAll('.navbar-modern .nav-link');

    function setActiveLink(sectionId) {
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href') ?? '';

            if (sectionId === 'top') {
                if (href.includes('{{ route('public.home') }}') && !href.includes('#')) {
                    link.classList.add('active');
                }
            } else {
                if (href.includes('#' + sectionId)) {
                    link.classList.add('active');
                }
            }
        });
    }

    function updateActiveNav() {
        const scrollY = window.scrollY;
        const offset = 120;
        const sections = ['arsip', 'statistik', 'tentang'];
        let current = 'top';

        for (const id of sections) {
            const el = document.getElementById(id);
            if (el) {
                const top = el.getBoundingClientRect().top + scrollY - offset;
                if (scrollY >= top) {
                    current = id;
                    break;
                }
            }
        }

        setActiveLink(current);
    }

    window.addEventListener('scroll', updateActiveNav);
    document.addEventListener('DOMContentLoaded', updateActiveNav);
</script>

</body>
</html>
