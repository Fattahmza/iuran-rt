<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iuran Desa - Sistem Iuran Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0a4d6e 0%, #063b54 30%, #022a3a 70%, #001a24 100%);
            overflow-x: hidden;
            position: relative;
        }

        /* Water Waves */
        .wave-bg {
            position: fixed; bottom: 0; left: 0; width: 100%; height: 150px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.15)" d="M0,192L48,197.3C96,203,192,213,288,208C384,203,480,181,576,186.7C672,192,768,224,864,229.3C960,235,1056,213,1152,192C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/></svg>') repeat-x;
            background-size: cover; animation: wave 12s linear infinite; z-index: 0; pointer-events: none;
        }
        .wave-bg-2 {
            position: fixed; bottom: 30px; left: 0; width: 100%; height: 120px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.08)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,138.7C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/></svg>') repeat-x;
            background-size: cover; animation: wave 18s linear infinite reverse; z-index: 0; pointer-events: none;
        }
        .wave-bg-3 {
            position: fixed; bottom: 60px; left: 0; width: 100%; height: 80px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" d="M0,224L48,213.3C96,203,192,181,288,176C384,171,480,181,576,197.3C672,213,768,235,864,229.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/></svg>') repeat-x;
            background-size: cover; animation: wave 25s linear infinite; z-index: 0; pointer-events: none;
        }
        @keyframes wave { 0% { background-position-x: 0; } 100% { background-position-x: 1440px; } }

        /* Bubbles */
        .bubble-bg {
            position: fixed; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.7), rgba(255,255,255,0.1));
            border-radius: 50%; animation: bubbleFloat 10s infinite ease-in-out; z-index: 0; pointer-events: none;
        }
        @keyframes bubbleFloat {
            0% { transform: translateY(100vh) scale(0.2); opacity: 0; }
            15% { opacity: 0.7; } 85% { opacity: 0.7; }
            100% { transform: translateY(-20vh) scale(1.2); opacity: 0; }
        }

        /* Ikan Besar di Tengah */
        .center-fish {
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            z-index: 20; pointer-events: none; animation: rotateFish 20s linear infinite;
        }
        @keyframes rotateFish { 0% { transform: translate(-50%, -50%) rotate(0deg); } 100% { transform: translate(-50%, -50%) rotate(360deg); } }
        .big-fish {
            position: relative; width: 100px; height: 50px; background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            border-radius: 50%; box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        .big-fish .strip { position: absolute; width: 10px; height: 55px; background: white; top: -2px; border-radius: 5px; }
        .big-fish .strip1 { left: 20px; transform: rotate(-5deg); }
        .big-fish .strip2 { left: 45px; }
        .big-fish .strip3 { left: 70px; transform: rotate(5deg); }
        .big-fish .eye { position: absolute; width: 12px; height: 12px; background: white; border-radius: 50%; top: 12px; right: 20px; }
        .big-fish .eye::after { content: ''; position: absolute; width: 6px; height: 6px; background: black; border-radius: 50%; top: 3px; right: 3px; }
        .big-fish .tail { position: absolute; width: 0; height: 0; border-left: 25px solid #ee5a24; border-top: 18px solid transparent; border-bottom: 18px solid transparent; left: -22px; top: 7px; animation: tailWiggle 0.6s infinite alternate; }
        .big-fish .fin { position: absolute; width: 0; height: 0; border-left: 15px solid transparent; border-right: 15px solid transparent; border-bottom: 20px solid #ee5a24; top: -15px; left: 40px; }
        @keyframes tailWiggle { from { transform: rotate(-10deg); } to { transform: rotate(10deg); } }

        /* Ikan Kecil Berenang */
        .small-fish {
            position: fixed; width: 40px; height: 20px; background: linear-gradient(135deg, #feca57, #ff9f43);
            border-radius: 50%; animation: swimFree 15s infinite linear; z-index: 15; pointer-events: none;
        }
        .small-fish .eye { position: absolute; width: 5px; height: 5px; background: white; border-radius: 50%; top: 5px; right: 8px; }
        .small-fish .tail { position: absolute; width: 0; height: 0; border-left: 10px solid #ff9f43; border-top: 7px solid transparent; border-bottom: 7px solid transparent; left: -9px; top: 3px; animation: tailWiggle 0.3s infinite alternate; }
        @keyframes swimFree {
            0% { transform: translateX(-200px) translateY(0) scaleX(1); }
            49% { transform: translateX(calc(100vw + 200px)) translateY(0) scaleX(1); }
            50% { transform: translateX(calc(100vw + 200px)) translateY(0) scaleX(-1); }
            99% { transform: translateX(-200px) translateY(0) scaleX(-1); }
            100% { transform: translateX(-200px) translateY(0) scaleX(1); }
        }

        /* Ikan Warna Lain */
        .green-fish {
            position: fixed; width: 35px; height: 18px; background: linear-gradient(135deg, #1dd1a1, #10ac84);
            border-radius: 50%; animation: swimFree 18s infinite linear; z-index: 15; pointer-events: none;
        }
        .green-fish .eye { position: absolute; width: 4px; height: 4px; background: white; border-radius: 50%; top: 4px; right: 7px; }
        .green-fish .tail { position: absolute; width: 0; height: 0; border-left: 9px solid #10ac84; border-top: 6px solid transparent; border-bottom: 6px solid transparent; left: -8px; top: 3px; animation: tailWiggle 0.4s infinite alternate; }

        .purple-fish {
            position: fixed; width: 45px; height: 22px; background: linear-gradient(135deg, #a29bfe, #6c5ce7);
            border-radius: 50%; animation: swimFree 20s infinite linear; z-index: 15; pointer-events: none;
        }
        .purple-fish .eye { position: absolute; width: 5px; height: 5px; background: white; border-radius: 50%; top: 6px; right: 9px; }
        .purple-fish .tail { position: absolute; width: 0; height: 0; border-left: 11px solid #6c5ce7; border-top: 7px solid transparent; border-bottom: 7px solid transparent; left: -10px; top: 4px; animation: tailWiggle 0.5s infinite alternate; }

        /* Coral & Light */
        .coral { position: fixed; bottom: 0; left: 20px; width: 30px; height: 60px; background: linear-gradient(135deg, #e74c3c, #c0392b); border-radius: 15px 15px 0 0; animation: sway 3s infinite alternate; transform-origin: bottom; z-index: 0; pointer-events: none; }
        .seaweed { position: fixed; bottom: 0; left: 70px; width: 20px; height: 70px; background: linear-gradient(135deg, #2ecc71, #27ae60); border-radius: 0 0 10px 10px; animation: sway 3.5s infinite alternate; transform-origin: bottom; z-index: 0; pointer-events: none; }
        .light-ray { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(ellipse at 30% 0%, rgba(255,255,255,0.12) 0%, transparent 50%); pointer-events: none; z-index: 0; animation: lightMove 10s infinite alternate; }
        @keyframes sway { from { transform: rotate(-5deg); } to { transform: rotate(5deg); } }
        @keyframes lightMove { 0% { opacity: 0.3; transform: translateX(-5%); } 100% { opacity: 0.7; transform: translateX(5%); } }

        /* Navbar */
        .navbar {
            background: rgba(10, 77, 110, 0.9);
            backdrop-filter: blur(15px);
            padding: 1rem 0;
            position: relative;
            z-index: 25;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .navbar-brand { font-size: 1.8rem; font-weight: 800; color: white !important; }
        .navbar-brand i { margin-right: 10px; font-size: 2rem; }
        .nav-link { color: white !important; font-weight: 500; transition: all 0.3s; }
        .nav-link:hover { opacity: 0.8; transform: translateY(-2px); }

        /* Split Screen Container */
        .split-container { min-height: 90vh; display: flex; position: relative; z-index: 10; }

        /* Left Panel */
        .info-panel {
            flex: 1; background: rgba(10, 77, 110, 0.85); backdrop-filter: blur(10px);
            display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 60px 40px; color: white;
        }
        .info-logo { width: 120px; height: 120px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 30px; animation: pulse 2s infinite; }
        .info-logo i { font-size: 60px; color: #ffd32a; }
        @keyframes pulse { 0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255,255,255,0.4); } 70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(255,255,255,0); } 100% { transform: scale(1); } }
        .info-title { font-size: 3rem; font-weight: 800; margin-bottom: 20px; text-align: center; }
        .info-title span { color: #ffd32a; display: inline-block; animation: floatText 3s ease-in-out infinite; }
        @keyframes floatText { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .info-text { text-align: center; font-size: 1.1rem; max-width: 450px; opacity: 0.9; line-height: 1.6; margin-bottom: 30px; }
        .info-features { display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; margin-bottom: 40px; }
        .info-feature { background: rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 20px; display: flex; align-items: center; gap: 10px; backdrop-filter: blur(5px); }
        .info-feature i { color: #ffd32a; font-size: 18px; }
        .info-feature span { font-size: 14px; }

        /* Right Panel */
        .form-panel {
            flex: 1; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
            display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 60px 40px;
        }
        .stats-container { text-align: center; max-width: 400px; width: 100%; }
        .stats-title { font-size: 2rem; font-weight: 700; color: #0a4d6e; margin-bottom: 40px; }
        .stats-title i { color: #ffd32a; margin-right: 10px; }
        .stat-card {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 20px; padding: 25px; margin-bottom: 20px; transition: all 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .stat-number { font-size: 3rem; font-weight: 800; color: #0a4d6e; }
        .stat-label { color: #718096; font-size: 14px; margin-top: 5px; }
        .stat-icon { font-size: 2rem; color: #ffd32a; margin-bottom: 15px; }

        .btn-primary-custom {
            background: linear-gradient(135deg, #0a4d6e, #006994);
            border: none; padding: 14px 32px; border-radius: 50px; font-weight: 600; font-size: 1rem;
            color: white; transition: all 0.3s; margin-top: 20px; width: 100%;
        }
        .btn-primary-custom:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(10,77,110,0.4); }
        .btn-outline-custom {
            background: transparent; border: 2px solid #0a4d6e; padding: 12px 30px;
            border-radius: 50px; font-weight: 600; color: #0a4d6e; transition: all 0.3s; width: 100%;
        }
        .btn-outline-custom:hover { background: #0a4d6e; color: white; transform: translateY(-3px); }

        .button-group { display: flex; gap: 15px; margin-top: 30px; }
        .button-group .btn-primary-custom, .button-group .btn-outline-custom { width: auto; flex: 1; }

        footer {
            background: rgba(0, 26, 36, 0.9); backdrop-filter: blur(10px);
            padding: 1.5rem 0; position: relative; z-index: 10; text-align: center;
            color: rgba(255,255,255,0.6); font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .split-container { flex-direction: column; }
            .info-panel { padding: 40px 20px; min-height: auto; }
            .info-title { font-size: 2rem; }
            .form-panel { padding: 40px 20px; }
            .stats-title { font-size: 1.5rem; }
            .stat-number { font-size: 2rem; }
            .button-group { flex-direction: column; }
            .button-group .btn-primary-custom, .button-group .btn-outline-custom { width: 100%; }
        }
    </style>
</head>
<body>
    <!-- Water Waves -->
    <div class="wave-bg"></div>
    <div class="wave-bg-2"></div>
    <div class="wave-bg-3"></div>
    <div class="light-ray"></div>

    <!-- Coral & Seaweed -->
    <div class="coral"></div>
    <div class="seaweed"></div>

    <!-- Ikan Besar di Tengah (Berputar) -->
    <div class="center-fish">
        <div class="big-fish">
            <div class="strip strip1"></div>
            <div class="strip strip2"></div>
            <div class="strip strip3"></div>
            <div class="eye"></div>
            <div class="tail"></div>
            <div class="fin"></div>
        </div>
    </div>

    <!-- Ikan Kecil Berenang Bebas -->
    <div class="small-fish" style="top: 10%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
    <div class="small-fish" style="top: 25%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
    <div class="green-fish" style="top: 45%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
    <div class="purple-fish" style="top: 65%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
    <div class="small-fish" style="top: 80%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
    <div class="green-fish" style="top: 90%; left: 0;"><div class="eye"></div><div class="tail"></div></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-landmark me-2"></i> Iuran Desa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="background-color: white; border-radius: 5px; padding: 5px;"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> Register</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Split Screen Content -->
    <div class="split-container">
        <!-- Left Panel - Info -->
        <div class="info-panel" data-aos="fade-right">
            <div class="info-logo">
                <i class="fas fa-landmark"></i>
            </div>
            <h1 class="info-title">Iuran <span>Desa</span></h1>
            <p class="info-text">
                Sistem digital untuk mengelola iuran warga dengan efisien,
                transparan, dan akuntabel. Laporan lengkap, export Excel,
                dan akses multi-user.
            </p>
            <div class="info-features">
                <div class="info-feature"><i class="fas fa-chart-line"></i><span>Dashboard Interaktif</span></div>
                <div class="info-feature"><i class="fas fa-file-excel"></i><span>Export ke Excel</span></div>
                <div class="info-feature"><i class="fas fa-chart-pie"></i><span>Laporan Lengkap</span></div>
                <div class="info-feature"><i class="fas fa-shield-alt"></i><span>Aman & Terpercaya</span></div>
                <div class="info-feature"><i class="fas fa-users"></i><span>Multi-User</span></div>
                <div class="info-feature"><i class="fas fa-chart-simple"></i><span>Real-time Stats</span></div>
            </div>
        </div>

        <!-- Right Panel - Stats & CTA -->
        <div class="form-panel" data-aos="fade-left">
            <div class="stats-container">
                <div class="stats-title">
                    <i class="fas fa-chart-simple"></i> Statistik Iuran
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number" id="statWarga">0</div>
                    <div class="stat-label">Warga Terdaftar</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-receipt"></i></div>
                    <div class="stat-number" id="statIuran">0</div>
                    <div class="stat-label">Total Transaksi Iuran</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="stat-number" id="statPemasukan">0</div>
                    <div class="stat-label">Total Pemasukan</div>
                </div>

                <div class="button-group">
                    @guest
                        <a href="{{ route('register') }}" class="btn-primary-custom">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn-outline-custom">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-primary-custom">
                            <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p><i class="fas fa-fish me-1"></i> Iuran Desa <i class="fas fa-water mx-2"></i> &copy; {{ date('Y') }} All Rights Reserved</p>
            <p style="font-size: 0.75rem;">Sistem pengelolaan iuran desa digital | Transparan | Akuntabel</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({ duration: 800, once: true });

        // Animate Numbers
        function animateNumber(elementId, start, end, duration, isCurrency = false) {
            const element = document.getElementById(elementId);
            if (!element) return;
            const startTime = performance.now();
            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const current = Math.floor(start + (end - start) * progress);
                if (isCurrency) {
                    element.textContent = 'Rp ' + current.toLocaleString('id-ID');
                } else {
                    element.textContent = current.toLocaleString('id-ID');
                }
                if (progress < 1) requestAnimationFrame(update);
            }
            requestAnimationFrame(update);
        }

        function startStats() {
            animateNumber('statWarga', 0, 150, 2000);
            animateNumber('statIuran', 0, 450, 2000);
            animateNumber('statPemasukan', 0, 125000000, 2000, true);
        }

        // Bubbles
        function createBubble() {
            const bubble = document.createElement('div');
            bubble.classList.add('bubble-bg');
            const size = Math.random() * 40 + 5;
            bubble.style.width = size + 'px';
            bubble.style.height = size + 'px';
            bubble.style.left = Math.random() * 100 + '%';
            bubble.style.animationDuration = Math.random() * 6 + 4 + 's';
            document.body.appendChild(bubble);
            setTimeout(() => bubble.remove(), 10000);
        }

        setInterval(createBubble, 350);
        window.addEventListener('load', startStats);
    </script>
</body>
</html>
