<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kas RT - Sistem Keuangan RT</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #006994 0%, #004e6e 50%, #003349 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        .wave-bg {
            position: fixed; bottom: 0; left: 0; width: 100%; height: 120px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.15)" d="M0,192L48,197.3C96,203,192,213,288,208C384,203,480,181,576,186.7C672,192,768,224,864,229.3C960,235,1056,213,1152,192C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/></svg>') repeat-x;
            background-size: cover; animation: wave 12s linear infinite; z-index: 0; pointer-events: none;
        }
        .wave-bg-2 {
            position: fixed; bottom: 30px; left: 0; width: 100%; height: 100px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.08)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,138.7C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/></svg>') repeat-x;
            background-size: cover; animation: wave 18s linear infinite reverse; z-index: 0; pointer-events: none;
        }
        @keyframes wave { 0% { background-position-x: 0; } 100% { background-position-x: 1440px; } }

        .bubble-bg {
            position: fixed; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.5), rgba(255,255,255,0.1));
            border-radius: 50%; animation: bubbleFloat 10s infinite ease-in-out; z-index: 0; pointer-events: none;
        }
        @keyframes bubbleFloat {
            0% { transform: translateY(100vh) scale(0.3); opacity: 0; }
            20% { opacity: 0.6; } 80% { opacity: 0.6; }
            100% { transform: translateY(-20vh) scale(1); opacity: 0; }
        }

        .fish-bg { position: fixed; z-index: 0; pointer-events: none; }
        .fish-body {
            position: relative; width: 50px; height: 25px; background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            border-radius: 50%; animation: swim 16s infinite linear;
        }
        .fish-eye { position: absolute; width: 5px; height: 5px; background: white; border-radius: 50%; top: 6px; right: 10px; }
        .fish-eye::after { content: ''; position: absolute; width: 2px; height: 2px; background: black; border-radius: 50%; top: 1px; right: 1px; }
        .fish-tail {
            position: absolute; width: 0; height: 0; border-left: 12px solid #ee5a24;
            border-top: 8px solid transparent; border-bottom: 8px solid transparent; left: -10px; top: 4px;
            animation: tailWiggle 0.4s infinite alternate;
        }
        @keyframes swim {
            0% { transform: translateX(-150px) scaleX(1); }
            49% { transform: translateX(calc(100vw + 150px)) scaleX(1); }
            50% { transform: translateX(calc(100vw + 150px)) scaleX(-1); }
            99% { transform: translateX(-150px) scaleX(-1); }
            100% { transform: translateX(-150px) scaleX(1); }
        }
        @keyframes tailWiggle { from { transform: rotate(-8deg); } to { transform: rotate(8deg); } }
        .fish2 .fish-body { background: linear-gradient(135deg, #feca57, #ff9f43); }
        .fish2 .fish-tail { border-left-color: #ff9f43; }
        .fish3 .fish-body { background: linear-gradient(135deg, #1dd1a1, #10ac84); width: 40px; height: 20px; }
        .fish4 .fish-body { background: linear-gradient(135deg, #a29bfe, #6c5ce7); width: 45px; height: 22px; }

        .light-reflection {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 60%);
            pointer-events: none; z-index: 0; animation: lightMove 8s infinite alternate;
        }
        @keyframes lightMove { from { opacity: 0.3; transform: translateX(-5%); } to { opacity: 0.6; transform: translateX(5%); } }

        .seaweed-bg {
            position: fixed; bottom: 0; left: 20px; width: 25px; height: 70px;
            background: linear-gradient(135deg, #2ecc71, #27ae60); border-radius: 0 0 12px 12px;
            animation: sway 3s infinite alternate; transform-origin: bottom; z-index: 0; pointer-events: none;
        }
        .seaweed-bg:nth-child(2) { left: 70px; height: 55px; width: 20px; animation-delay: 0.5s; }
        .seaweed-bg:nth-child(3) { right: 40px; left: auto; height: 85px; width: 30px; animation-delay: 1s; }
        .seaweed-bg:nth-child(4) { right: 100px; left: auto; height: 40px; width: 18px; animation-delay: 0.3s; }
        @keyframes sway { from { transform: rotate(-4deg); } to { transform: rotate(4deg); } }

        .sidebar {
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
            min-height: 100vh; position: sticky; top: 0; z-index: 100;
            border-right: 1px solid rgba(255,255,255,0.3);
        }
        .sidebar .nav-link {
            color: #006994; padding: 0.6rem 1rem; border-radius: 0.5rem; margin: 0.1rem 0;
            transition: all 0.3s; font-weight: 500;
        }
        .sidebar .nav-link:hover { background: rgba(0,105,148,0.1); transform: translateX(5px); }
        .sidebar .nav-link.active { background: linear-gradient(135deg, #006994, #004e6e); color: white; }
        .sidebar .nav-link i { width: 24px; margin-right: 10px; text-align: center; }
        .sidebar .section-title { color: #006994; font-size: 0.7rem; font-weight: 600; margin-top: 1rem; margin-bottom: 0.5rem; padding-left: 0.5rem; letter-spacing: 1px; }

        .main-content {
            background: rgba(255,255,255,0.92); backdrop-filter: blur(5px);
            min-height: 100vh; border-radius: 2rem 0 0 2rem; z-index: 1; position: relative;
        }
        .card { border: none; border-radius: 1rem; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: all 0.3s; background: white; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .btn-gradient { background: linear-gradient(135deg, #006994, #004e6e); border: none; color: white; padding: 0.5rem 1.5rem; border-radius: 2rem; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,105,148,0.4); color: white; }
        .table thead th { background: linear-gradient(135deg, #006994, #004e6e); color: white; font-weight: 600; border: none; }
        .welcome-section { background: linear-gradient(135deg, #006994, #004e6e); border-radius: 1.5rem; padding: 2rem; color: white; margin-bottom: 2rem; position: relative; overflow: hidden; }
        .modal { z-index: 2000 !important; }
        .modal-backdrop { z-index: 1990 !important; }
        .welcome-section::before { content: '🐠🐟🐡🦈'; position: absolute; bottom: 10px; right: 20px; font-size: 50px; opacity: 0.1; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.5s ease-out; }

        .badge-pending { background-color: #fff3cd; color: #856404; }
        .badge-verified { background-color: #d4edda; color: #155724; }
        .badge-rejected { background-color: #f8d7da; color: #721c24; }
        .badge-lunas { background-color: #d4edda; color: #155724; }
        .badge-belum { background-color: #fff3cd; color: #856404; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="wave-bg"></div>
    <div class="wave-bg-2"></div>
    <div class="seaweed-bg"></div>
    <div class="seaweed-bg"></div>
    <div class="seaweed-bg"></div>
    <div class="seaweed-bg"></div>
    <div class="light-reflection"></div>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-auto sidebar" style="width: 270px;">
                <div class="p-3">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle p-2 d-inline-block mb-2" style="background: linear-gradient(135deg, #006994, #004e6e);">
                            <i class="fas fa-money-bill-wave fa-2x text-white"></i>
                        </div>
                        <h5 class="fw-bold mb-0" style="color: #006994;">Kas RT</h5>
                        <small class="text-muted">Keuangan RT</small>
                    </div>
                    <hr>
                    <nav class="nav flex-column">

                        @auth
                            @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                                <!-- MENU UNTUK ADMIN & BENDAHARA -->
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>

                                <div class="section-title">IURAN</div>
                                <a class="nav-link {{ request()->routeIs('iuran.index') ? 'active' : '' }}" href="{{ route('iuran.index') }}">
                                    <i class="fas fa-database"></i> Data Iuran
                                </a>
                                <a class="nav-link {{ request()->routeIs('iuran.create') ? 'active' : '' }}" href="{{ route('iuran.create') }}">
                                    <i class="fas fa-plus-circle"></i> Tambah Iuran
                                </a>
                                <a class="nav-link {{ request()->routeIs('jenis-iuran.index') ? 'active' : '' }}" href="{{ route('jenis-iuran.index') }}">
                                    <i class="fas fa-tags"></i> Buat Iuran Baru
                                </a>

                                <div class="section-title">VERIFIKASI</div>
                                <a class="nav-link {{ request()->routeIs('iuran.verifikasi') ? 'active' : '' }}" href="{{ route('iuran.verifikasi') }}">
                                    <i class="fas fa-check-double"></i> Verifikasi Pembayaran
                                </a>

                                <div class="section-title">MASTER DATA</div>
                                <a class="nav-link {{ request()->routeIs('warga.index') ? 'active' : '' }}" href="{{ route('warga.index') }}">
                                    <i class="fas fa-users"></i> Warga
                                </a>

                                <div class="section-title">LAPORAN</div>
                                <a class="nav-link {{ request()->routeIs('iuran.laporan') ? 'active' : '' }}" href="{{ route('iuran.laporan') }}">
                                    <i class="fas fa-chart-line"></i> Laporan Keuangan
                                </a>
                                <a class="nav-link {{ request()->routeIs('laporan-iuran.index') ? 'active' : '' }}" href="{{ route('laporan-iuran.index') }}">
                                    <i class="fas fa-file-invoice"></i> Laporan Iuran
                                </a>
                                <a class="nav-link {{ request()->routeIs('iuran.export') ? 'active' : '' }}" href="{{ route('iuran.export') }}">
                                    <i class="fas fa-file-excel"></i> Export Laporan
                                </a>

                                <div class="section-title">PROFIL</div>
                                <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-circle"></i> Profil Saya
                                </a>

                            @else
                                <!-- MENU UNTUK WARGA -->
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>

                                <div class="section-title">IURAN</div>
                                <a class="nav-link {{ request()->routeIs('iuran.create') ? 'active' : '' }}" href="{{ route('iuran.create') }}">
                                    <i class="fas fa-credit-card"></i> Bayar Iuran
                                </a>
                                <a class="nav-link {{ request()->routeIs('iuran.index') ? 'active' : '' }}" href="{{ route('iuran.index') }}">
                                    <i class="fas fa-history"></i> Riwayat Pembayaran
                                </a>

                                <div class="section-title">PROFIL</div>
                                <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-circle"></i> Profil Saya
                                </a>
                            @endif
                        @endauth

                        <hr class="mt-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">
                                <i class="fas fa-sign-out-alt me-2"></i> Keluar
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col main-content p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-0" style="color: #006994;">@yield('header', 'Dashboard')</h2>
                        <small class="text-muted">@yield('subheader', 'Selamat datang di Sistem Kas RT')</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light rounded-pill dropdown-toggle" data-bs-toggle="dropdown" style="background: white; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                            @php
                                $user = Auth::user();
                                $avatarUrl = $user && $user->avatar ? asset('storage/avatars/' . $user->avatar) : 'https://ui-avatars.com/api/?background=006994&color=fff&name=' . urlencode($user->name ?? 'User');
                            @endphp
                            <img src="{{ $avatarUrl }}" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                            {{ $user->name ?? 'User' }}
                            <span class="badge ms-2" style="background: #006994;">{{ $user->role->display_name ?? 'User' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                setTimeout(() => bsAlert.close(), 5000);
            });
        }, 1000);

        function createBubble() {
            const bubble = document.createElement('div');
            bubble.classList.add('bubble-bg');
            const size = Math.random() * 40 + 10;
            bubble.style.width = size + 'px';
            bubble.style.height = size + 'px';
            bubble.style.left = Math.random() * 100 + '%';
            bubble.style.animationDuration = Math.random() * 6 + 5 + 's';
            bubble.style.animationDelay = Math.random() * 5 + 's';
            document.body.appendChild(bubble);
            setTimeout(() => bubble.remove(), 10000);
        }

        function createFish() {
            const fish = document.createElement('div');
            fish.classList.add('fish-bg');
            fish.classList.add('fish' + (Math.floor(Math.random() * 4) + 1));
            fish.style.top = Math.random() * 80 + 10 + '%';
            fish.style.animationDuration = Math.random() * 12 + 18 + 's';
            fish.style.animationDelay = Math.random() * 8 + 's';
            fish.innerHTML = `<div class="fish-body"><div class="fish-eye"></div><div class="fish-tail"></div></div>`;
            document.body.appendChild(fish);
            setTimeout(() => fish.remove(), 30000);
        }

        setInterval(createBubble, 400);
        setInterval(createFish, 10000);
        for(let i = 0; i < 4; i++) { setTimeout(() => createFish(), i * 2500); }

        window.confirmDelete = function(id, url) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        };
    </script>

    @stack('scripts')
</body>
</html>
