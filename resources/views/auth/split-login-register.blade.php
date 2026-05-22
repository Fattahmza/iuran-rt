<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iuran Desa - Login & Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        /* Coral & Light */
        .coral { position: fixed; bottom: 0; left: 20px; width: 30px; height: 60px; background: linear-gradient(135deg, #e74c3c, #c0392b); border-radius: 15px 15px 0 0; animation: sway 3s infinite alternate; transform-origin: bottom; z-index: 0; pointer-events: none; }
        .seaweed { position: fixed; bottom: 0; left: 70px; width: 20px; height: 70px; background: linear-gradient(135deg, #2ecc71, #27ae60); border-radius: 0 0 10px 10px; animation: sway 3.5s infinite alternate; transform-origin: bottom; z-index: 0; pointer-events: none; }
        .light-ray { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(ellipse at 30% 0%, rgba(255,255,255,0.12) 0%, transparent 50%); pointer-events: none; z-index: 0; animation: lightMove 10s infinite alternate; }
        @keyframes sway { from { transform: rotate(-5deg); } to { transform: rotate(5deg); } }
        @keyframes lightMove { 0% { opacity: 0.3; transform: translateX(-5%); } 100% { opacity: 0.7; transform: translateX(5%); } }

        /* Split Screen */
        .split-container { min-height: 100vh; display: flex; position: relative; z-index: 10; }
        .info-panel {
            flex: 1; background: rgba(10, 77, 110, 0.85); backdrop-filter: blur(10px);
            display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 40px; color: white;
        }
        .info-logo { width: 100px; height: 100px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 30px; animation: pulse 2s infinite; }
        .info-logo i { font-size: 50px; color: #ffd32a; }
        @keyframes pulse { 0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255,255,255,0.4); } 70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(255,255,255,0); } 100% { transform: scale(1); } }
        .info-title { font-size: 2.5rem; font-weight: 800; margin-bottom: 20px; text-align: center; }
        .info-title span { color: #ffd32a; }
        .info-text { text-align: center; font-size: 1rem; max-width: 400px; opacity: 0.9; }
        .info-features { margin-top: 40px; display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; }
        .info-feature { background: rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 18px; display: flex; align-items: center; gap: 8px; }
        .info-feature i { color: #ffd32a; }

        /* Form Panel */
        .form-panel { flex: 1; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 40px; }
        .toggle-buttons { display: flex; gap: 15px; margin-bottom: 30px; background: #f0f2f5; padding: 5px; border-radius: 50px; }
        .toggle-btn { padding: 12px 30px; border: none; border-radius: 50px; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s; background: transparent; color: #718096; }
        .toggle-btn.active { background: linear-gradient(135deg, #0a4d6e, #006994); color: white; box-shadow: 0 5px 15px rgba(10,77,110,0.3); }
        .form-wrapper { width: 100%; max-width: 400px; }
        .form-title { font-size: 28px; font-weight: 700; color: #0a4d6e; margin-bottom: 30px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        .form-label { font-weight: 600; margin-bottom: 8px; color: #2d3748; font-size: 14px; }
        .input-group-custom { border: 2px solid #e2e8f0; border-radius: 16px; transition: all 0.3s; background: white; display: flex; align-items: center; }
        .input-group-custom:focus-within { border-color: #0a4d6e; box-shadow: 0 0 0 3px rgba(10,77,110,0.1); }
        .input-icon { padding: 12px 0 12px 16px; color: #0a4d6e; }
        .input-group-custom input, .input-group-custom textarea { border: none; padding: 12px 16px 12px 0; font-size: 15px; background: transparent; flex: 1; outline: none; }
        .password-toggle { padding: 12px 16px; cursor: pointer; color: #718096; }
        .btn-submit { background: linear-gradient(135deg, #0a4d6e, #006994); border: none; padding: 14px; border-radius: 16px; font-weight: 600; font-size: 16px; width: 100%; color: white; transition: all 0.3s; margin-top: 10px; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(10,77,110,0.4); }
        .demo-accounts { background: #e8f4f8; border-radius: 16px; padding: 16px; margin-top: 20px; }
        .demo-title { font-size: 12px; font-weight: 600; color: #0a4d6e; margin-bottom: 10px; }
        .demo-item { font-size: 12px; padding: 6px 0; border-bottom: 1px solid #cbd5e0; }
        .demo-item:last-child { border-bottom: none; }
        .demo-item strong { color: #0a4d6e; }
        .spinner { display: none; width: 20px; height: 20px; border: 2px solid white; border-top-color: transparent; border-radius: 50%; animation: spin 0.8s linear infinite; margin-right: 8px; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Register Steps */
        .register-steps { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .step-indicator { flex: 1; text-align: center; }
        .step-number { width: 35px; height: 35px; background: white; border: 2px solid #cbd5e0; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; color: #718096; transition: all 0.3s; }
        .step-indicator.active .step-number { background: linear-gradient(135deg, #0a4d6e, #006994); border-color: #0a4d6e; color: white; }
        .step-indicator.completed .step-number { background: #2ecc71; border-color: #2ecc71; color: white; }
        .step-indicator.completed .step-number i { font-size: 14px; }
        .step-label { font-size: 11px; margin-top: 6px; color: #718096; }
        .step-indicator.active .step-label { color: #0a4d6e; font-weight: 600; }
        .form-step { display: none; animation: fadeIn 0.5s ease-out; }
        .form-step.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        .password-strength { margin-top: 8px; }
        .strength-bar { height: 4px; background: #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 5px; }
        .strength-fill { width: 0%; height: 100%; transition: width 0.3s; }
        .strength-text { font-size: 11px; color: #718096; }
        .strength-weak .strength-fill { width: 25%; background: #e53e3e; }
        .strength-medium .strength-fill { width: 50%; background: #ed8936; }
        .strength-strong .strength-fill { width: 75%; background: #38a169; }
        .strength-very-strong .strength-fill { width: 100%; background: #38a169; }

        @media (max-width: 768px) {
            .split-container { flex-direction: column; }
            .info-panel { padding: 30px; min-height: 300px; }
            .info-title { font-size: 1.8rem; }
            .form-panel { padding: 30px; }
        }
    </style>
</head>
<body>
    <div class="wave-bg"></div>
    <div class="wave-bg-2"></div>
    <div class="wave-bg-3"></div>
    <div class="light-ray"></div>
    <div class="coral"></div>
    <div class="seaweed"></div>

    <!-- Ikan Besar di Tengah -->
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

    <!-- Ikan Kecil -->
    <div class="small-fish" style="top: 15%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
    <div class="small-fish" style="top: 30%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
    <div class="small-fish" style="top: 70%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
    <div class="small-fish" style="top: 85%; left: 0;"><div class="eye"></div><div class="tail"></div></div>

    <div class="split-container">
        <!-- Left Panel -->
        <div class="info-panel">
            <div class="info-logo"><i class="fas fa-landmark"></i></div>
            <h1 class="info-title">Iuran <span>Desa</span></h1>
            <p class="info-text">Sistem digital untuk mengelola iuran warga dengan efisien, transparan, dan akuntabel.</p>
            <div class="info-features">
                <div class="info-feature"><i class="fas fa-chart-line"></i><span>Dashboard Interaktif</span></div>
                <div class="info-feature"><i class="fas fa-file-excel"></i><span>Export ke Excel</span></div>
                <div class="info-feature"><i class="fas fa-shield-alt"></i><span>Aman & Terpercaya</span></div>
            </div>
            <div class="mt-4 text-center"><small style="opacity: 0.7;">&copy; 2024 Iuran Desa</small></div>
        </div>

        <!-- Right Panel -->
        <div class="form-panel">
            <div class="toggle-buttons">
                <button class="toggle-btn active" id="btnLogin" onclick="showLogin()">Login</button>
                <button class="toggle-btn" id="btnRegister" onclick="showRegister()">Register</button>
            </div>

            <!-- Login Form -->
            <div id="loginSection" class="form-wrapper" style="display: block;">
                <h2 class="form-title">Welcome Back! 🐠</h2>
                @if ($errors->any())
                    <div class="alert alert-danger mb-4" style="border-radius: 16px;">
                        @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <div class="input-group-custom">
                            <span class="input-icon"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" placeholder="yourname@company.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <div class="input-group-custom">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="loginPassword" placeholder="Enter your password" required>
                            <span class="password-toggle" onclick="togglePassword('loginPassword', this)"><i class="fas fa-eye-slash"></i></span>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <div class="form-check"><input type="checkbox" name="remember" id="remember" class="form-check-input"><label for="remember" class="form-check-label">Remember me</label></div>
                        @if (Route::has('password.request'))<a href="{{ route('password.request') }}" style="color:#0a4d6e; font-size:13px;">Forgot password?</a>@endif
                    </div>
                    <button type="submit" class="btn-submit">Sign In</button>
                </form>
                <div class="demo-accounts">
                    <div class="demo-title"><i class="fas fa-info-circle me-1"></i> Demo Accounts</div>
                    <div class="demo-item"><strong>Admin:</strong> admin@iurandesaku.com / password</div>
                    <div class="demo-item"><strong>Bendahara:</strong> bendahara@iurandesaku.com / password</div>
                    <div class="demo-item"><strong>Warga:</strong> warga1@iurandesaku.com / password</div>
                </div>
            </div>

            <!-- Register Form -->
            <div id="registerSection" class="form-wrapper" style="display: none;">
                <h2 class="form-title">Create Account 🐡</h2>
                <div class="register-steps">
                    <div class="step-indicator active" id="regStep1"><div class="step-number">1</div><div class="step-label">Personal</div></div>
                    <div class="step-indicator" id="regStep2"><div class="step-number">2</div><div class="step-label">Contact</div></div>
                    <div class="step-indicator" id="regStep3"><div class="step-number">3</div><div class="step-label">Security</div></div>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-step active" id="step1">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <div class="input-group-custom"><span class="input-icon"><i class="fas fa-user"></i></span><input type="text" name="name" placeholder="John Doe" value="{{ old('name') }}" required></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <div class="input-group-custom"><span class="input-icon"><i class="fas fa-envelope"></i></span><input type="email" name="email" placeholder="yourname@company.com" value="{{ old('email') }}" required></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <div class="input-group-custom"><span class="input-icon"><i class="fas fa-phone"></i></span><input type="text" name="phone" placeholder="08123456789" value="{{ old('phone') }}"></div>
                        </div>
                        <div style="display: flex; justify-content: flex-end;"><button type="button" class="btn-submit" style="width: auto; padding: 10px 25px;" onclick="nextStep(2)">Next <i class="fas fa-arrow-right ms-2"></i></button></div>
                    </div>
                    <div class="form-step" id="step2">
                        <div class="form-group">
                            <label class="form-label">NIK (Optional)</label>
                            <div class="input-group-custom"><span class="input-icon"><i class="fas fa-id-card"></i></span><input type="text" name="nik" placeholder="16 digit NIK" value="{{ old('nik') }}" maxlength="16"></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><div class="form-group"><label class="form-label">RT</label><div class="input-group-custom"><span class="input-icon"><i class="fas fa-home"></i></span><input type="text" name="rt" placeholder="01" value="{{ old('rt') }}"></div></div></div>
                            <div class="col-6"><div class="form-group"><label class="form-label">RW</label><div class="input-group-custom"><span class="input-icon"><i class="fas fa-home"></i></span><input type="text" name="rw" placeholder="01" value="{{ old('rw') }}"></div></div></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <div class="input-group-custom"><span class="input-icon"><i class="fas fa-map-marker-alt"></i></span><textarea name="address" rows="2" placeholder="Your address...">{{ old('address') }}</textarea></div>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <button type="button" class="btn-submit" style="width: auto; padding: 10px 25px; background: #e2e8f0; color: #4a5568;" onclick="prevStep(1)"><i class="fas fa-arrow-left me-2"></i> Back</button>
                            <button type="button" class="btn-submit" style="width: auto; padding: 10px 25px;" onclick="nextStep(3)">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                    <div class="form-step" id="step3">
                        <div class="form-group">
                            <label class="form-label">Password *</label>
                            <div class="input-group-custom"><span class="input-icon"><i class="fas fa-lock"></i></span><input type="password" name="password" id="regPassword" placeholder="Create a password" required><span class="password-toggle" onclick="togglePassword('regPassword', this)"><i class="fas fa-eye-slash"></i></span></div>
                            <div class="password-strength" id="passwordStrength"><div class="strength-bar"><div class="strength-fill"></div></div><div class="strength-text">Enter a strong password</div></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password *</label>
                            <div class="input-group-custom"><span class="input-icon"><i class="fas fa-lock"></i></span><input type="password" name="password_confirmation" id="confirmPassword" placeholder="Confirm your password" required><span class="password-toggle" onclick="togglePassword('confirmPassword', this)"><i class="fas fa-eye-slash"></i></span></div>
                            <small id="passwordMatch" class="text-muted"></small>
                        </div>
                        <div class="alert alert-info mt-3" style="font-size:12px; padding:10px; border-radius:12px; background:#e8f4f8; border:none; color:#0a4d6e;"><i class="fas fa-info-circle me-2"></i> After registration, your account will be activated by admin.</div>
                        <div style="display: flex; justify-content: space-between;">
                            <button type="button" class="btn-submit" style="width: auto; padding: 10px 25px; background: #e2e8f0; color: #4a5568;" onclick="prevStep(2)"><i class="fas fa-arrow-left me-2"></i> Back</button>
                            <button type="submit" class="btn-submit" style="width: auto; padding: 10px 25px;">Create Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLogin() {
            document.getElementById('loginSection').style.display = 'block';
            document.getElementById('registerSection').style.display = 'none';
            document.getElementById('btnLogin').classList.add('active');
            document.getElementById('btnRegister').classList.remove('active');
        }
        function showRegister() {
            document.getElementById('loginSection').style.display = 'none';
            document.getElementById('registerSection').style.display = 'block';
            document.getElementById('btnRegister').classList.add('active');
            document.getElementById('btnLogin').classList.remove('active');
        }
        function togglePassword(fieldId, element) {
            const field = document.getElementById(fieldId);
            const icon = element.querySelector('i');
            if (field.type === 'password') { field.type = 'text'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
            else { field.type = 'password'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
        }
        let currentStep = 1;
        function updateSteps() {
            for(let i=1; i<=3; i++) {
                const step = document.getElementById(`regStep${i}`);
                if(i < currentStep) { step.classList.add('completed'); step.classList.remove('active'); step.querySelector('.step-number').innerHTML = '<i class="fas fa-check"></i>'; }
                else if(i === currentStep) { step.classList.add('active'); step.classList.remove('completed'); step.querySelector('.step-number').innerHTML = i; }
                else { step.classList.remove('active','completed'); step.querySelector('.step-number').innerHTML = i; }
            }
        }
        function nextStep(step) {
            if(currentStep === 1) {
                const name = document.querySelector('input[name="name"]').value;
                const email = document.querySelector('input[name="email"]').value;
                if(!name || !email) { Swal.fire({ icon:'warning', title:'Incomplete', text:'Please fill Name and Email', confirmButtonColor:'#0a4d6e' }); return; }
            }
            currentStep = step; updateSteps();
            document.querySelectorAll('.form-step').forEach((el,idx) => { el.classList.remove('active'); if(idx+1 === step) el.classList.add('active'); });
        }
        function prevStep(step) { currentStep = step; updateSteps(); document.querySelectorAll('.form-step').forEach((el,idx) => { el.classList.remove('active'); if(idx+1 === step) el.classList.add('active'); }); }

        const regPassword = document.getElementById('regPassword');
        const strengthDiv = document.getElementById('passwordStrength');
        regPassword?.addEventListener('input', function() {
            let val=this.value, strength=0;
            if(val.length>=6) strength++;
            if(val.match(/[a-z]+/)) strength++;
            if(val.match(/[A-Z]+/)) strength++;
            if(val.match(/[0-9]+/)) strength++;
            if(val.match(/[$@#&!]+/)) strength++;
            strengthDiv.classList.remove('strength-weak','strength-medium','strength-strong','strength-very-strong');
            if(val.length===0) strengthDiv.querySelector('.strength-text').innerHTML='Enter a strong password';
            else if(strength<=2) { strengthDiv.classList.add('strength-weak'); strengthDiv.querySelector('.strength-text').innerHTML='Weak password'; }
            else if(strength===3) { strengthDiv.classList.add('strength-medium'); strengthDiv.querySelector('.strength-text').innerHTML='Medium password'; }
            else if(strength===4) { strengthDiv.classList.add('strength-strong'); strengthDiv.querySelector('.strength-text').innerHTML='Strong password'; }
            else { strengthDiv.classList.add('strength-very-strong'); strengthDiv.querySelector('.strength-text').innerHTML='Very strong password'; }
        });

        const confirmPassword = document.getElementById('confirmPassword');
        const passwordMatch = document.getElementById('passwordMatch');
        function checkMatch() {
            if(confirmPassword?.value.length===0) { passwordMatch.innerHTML=''; }
            else if(regPassword?.value===confirmPassword?.value) { passwordMatch.innerHTML='<i class="fas fa-check-circle text-success me-1"></i>Passwords match!'; passwordMatch.className='text-success'; }
            else { passwordMatch.innerHTML='<i class="fas fa-times-circle text-danger me-1"></i>Passwords do not match!'; passwordMatch.className='text-danger'; }
        }
        regPassword?.addEventListener('input', checkMatch);
        confirmPassword?.addEventListener('input', checkMatch);

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
    </script>
</body>
</html>
