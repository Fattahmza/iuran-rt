<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Iuran Desa</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
        .wave-bg { position: fixed; bottom: 0; left: 0; width: 100%; height: 150px; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.15)" d="M0,192L48,197.3C96,203,192,213,288,208C384,203,480,181,576,186.7C672,192,768,224,864,229.3C960,235,1056,213,1152,192C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/></svg>') repeat-x; background-size: cover; animation: wave 12s linear infinite; z-index: 0; pointer-events: none; }
        .wave-bg-2 { position: fixed; bottom: 30px; left: 0; width: 100%; height: 120px; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.08)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,138.7C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/></svg>') repeat-x; background-size: cover; animation: wave 18s linear infinite reverse; z-index: 0; pointer-events: none; }
        .wave-bg-3 { position: fixed; bottom: 60px; left: 0; width: 100%; height: 80px; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" d="M0,224L48,213.3C96,203,192,181,288,176C384,171,480,181,576,197.3C672,213,768,235,864,229.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"/></svg>') repeat-x; background-size: cover; animation: wave 25s linear infinite; z-index: 0; pointer-events: none; }
        @keyframes wave { 0% { background-position-x: 0; } 100% { background-position-x: 1440px; } }

        /* Bubbles */
        .bubble-bg { position: fixed; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.7), rgba(255,255,255,0.1)); border-radius: 50%; box-shadow: inset -3px -3px 8px rgba(0,0,0,0.05), 0 0 15px rgba(255,255,255,0.4); animation: bubbleFloat 10s infinite ease-in-out; z-index: 0; pointer-events: none; }
        @keyframes bubbleFloat { 0% { transform: translateY(100vh) scale(0.2); opacity: 0; } 15% { opacity: 0.7; } 85% { opacity: 0.7; } 100% { transform: translateY(-20vh) scale(1.2); opacity: 0; } }

        /* Fish Styles - SAME AS LOGIN */
        .fish-bg { position: fixed; z-index: 0; pointer-events: none; }
        .clownfish { position: relative; width: 70px; height: 35px; background: linear-gradient(135deg, #ff6b6b, #ee5a24); border-radius: 50%; animation: swim 18s infinite linear; }
        .clownfish .strip { position: absolute; width: 8px; height: 40px; background: white; top: -2px; border-radius: 4px; }
        .clownfish .strip1 { left: 15px; transform: rotate(-5deg); } .clownfish .strip2 { left: 35px; } .clownfish .strip3 { left: 55px; transform: rotate(5deg); }
        .clownfish .eye { position: absolute; width: 8px; height: 8px; background: white; border-radius: 50%; top: 8px; right: 15px; }
        .clownfish .eye::after { content: ''; position: absolute; width: 4px; height: 4px; background: black; border-radius: 50%; top: 2px; right: 2px; }
        .clownfish .tail { position: absolute; width: 0; height: 0; border-left: 18px solid #ee5a24; border-top: 12px solid transparent; border-bottom: 12px solid transparent; left: -15px; top: 6px; animation: tailWiggle 0.4s infinite alternate; }

        .shark { position: relative; width: 100px; height: 40px; background: linear-gradient(135deg, #6c7a89, #4a5568); border-radius: 50%; animation: swim 22s infinite linear; }
        .shark .fin { position: absolute; width: 0; height: 0; border-left: 15px solid transparent; border-right: 15px solid transparent; border-bottom: 25px solid #4a5568; top: -18px; left: 30px; }
        .shark .fin2 { position: absolute; width: 0; height: 0; border-left: 8px solid transparent; border-right: 8px solid transparent; border-bottom: 12px solid #4a5568; top: -8px; right: 15px; }
        .shark .eye { position: absolute; width: 8px; height: 8px; background: white; border-radius: 50%; top: 10px; right: 20px; }
        .shark .mouth { position: absolute; width: 15px; height: 6px; background: #2d3748; border-radius: 50%; top: 22px; right: 5px; }
        .shark .teeth { position: absolute; width: 0; height: 0; border-left: 3px solid transparent; border-right: 3px solid transparent; border-bottom: 4px solid white; top: 20px; right: 12px; }
        .shark .tail { position: absolute; width: 0; height: 0; border-left: 25px solid #4a5568; border-top: 15px solid transparent; border-bottom: 15px solid transparent; left: -20px; top: 5px; animation: tailWiggle 0.5s infinite alternate; }

        .koi { position: relative; width: 75px; height: 32px; background: linear-gradient(135deg, #ff4757, #ff6b81); border-radius: 50%; animation: swim 20s infinite linear; }
        .koi .spot { position: absolute; background: white; border-radius: 50%; opacity: 0.8; }
        .koi .spot1 { width: 12px; height: 12px; top: 5px; left: 20px; }
        .koi .spot2 { width: 8px; height: 8px; top: 18px; left: 35px; }
        .koi .spot3 { width: 10px; height: 10px; top: 8px; left: 50px; }
        .koi .eye { position: absolute; width: 7px; height: 7px; background: white; border-radius: 50%; top: 8px; right: 18px; }
        .koi .tail { position: absolute; width: 0; height: 0; border-left: 20px solid #ff6b81; border-top: 10px solid transparent; border-bottom: 10px solid transparent; left: -16px; top: 6px; animation: tailWiggle 0.6s infinite alternate; }

        .stingray { position: relative; width: 90px; height: 25px; background: linear-gradient(135deg, #8e44ad, #9b59b6); border-radius: 50%; animation: swim 25s infinite linear; }
        .stingray .wing { position: absolute; width: 30px; height: 20px; background: #9b59b6; border-radius: 50%; top: -10px; left: 20px; transform: rotate(-15deg); }
        .stingray .wing2 { position: absolute; width: 30px; height: 20px; background: #9b59b6; border-radius: 50%; bottom: -10px; left: 20px; transform: rotate(15deg); }
        .stingray .eye { position: absolute; width: 6px; height: 6px; background: white; border-radius: 50%; top: 8px; right: 25px; }
        .stingray .tail-long { position: absolute; width: 40px; height: 3px; background: #8e44ad; right: -35px; top: 11px; border-radius: 2px; animation: tailWiggle 0.8s infinite alternate; }

        .nemo { position: relative; width: 50px; height: 25px; background: linear-gradient(135deg, #ffa502, #ff6348); border-radius: 50%; animation: swim 14s infinite linear; }
        .nemo .stripe { position: absolute; width: 6px; height: 30px; background: white; top: -2px; border-radius: 3px; }
        .nemo .stripe1 { left: 12px; } .nemo .stripe2 { left: 28px; }
        .nemo .eye { position: absolute; width: 6px; height: 6px; background: white; border-radius: 50%; top: 6px; right: 10px; }
        .nemo .tail { position: absolute; width: 0; height: 0; border-left: 12px solid #ff6348; border-top: 8px solid transparent; border-bottom: 8px solid transparent; left: -10px; top: 4px; animation: tailWiggle 0.3s infinite alternate; }

        .archer { position: relative; width: 55px; height: 28px; background: linear-gradient(135deg, #2ecc71, #27ae60); border-radius: 50%; animation: swim 16s infinite linear; }
        .archer .eye { position: absolute; width: 6px; height: 6px; background: white; border-radius: 50%; top: 7px; right: 12px; }
        .archer .tail { position: absolute; width: 0; height: 0; border-left: 14px solid #27ae60; border-top: 9px solid transparent; border-bottom: 9px solid transparent; left: -12px; top: 5px; animation: tailWiggle 0.4s infinite alternate; }

        .puffer { position: relative; width: 40px; height: 40px; background: linear-gradient(135deg, #fdcb6e, #f39c12); border-radius: 50%; animation: swim 12s infinite linear; }
        .puffer .spike { position: absolute; width: 4px; height: 10px; background: #e67e22; border-radius: 2px; }
        .puffer .spike1 { top: -5px; left: 10px; transform: rotate(-20deg); } .puffer .spike2 { top: -8px; left: 20px; } .puffer .spike3 { top: -5px; left: 30px; transform: rotate(20deg); }
        .puffer .spike4 { bottom: -5px; left: 10px; transform: rotate(20deg); } .puffer .spike5 { bottom: -8px; left: 20px; } .puffer .spike6 { bottom: -5px; left: 30px; transform: rotate(-20deg); }
        .puffer .eye { position: absolute; width: 8px; height: 8px; background: white; border-radius: 50%; top: 12px; right: 8px; }
        .puffer .mouth { position: absolute; width: 8px; height: 4px; background: #e67e22; border-radius: 50%; top: 24px; right: 12px; }

        .louhan { position: relative; width: 65px; height: 40px; background: linear-gradient(135deg, #e84393, #fd79a8); border-radius: 50%; animation: swim 19s infinite linear; }
        .louhan .head { position: absolute; width: 25px; height: 25px; background: #fd79a8; border-radius: 50%; top: -8px; right: 5px; }
        .louhan .eye { position: absolute; width: 7px; height: 7px; background: white; border-radius: 50%; top: 5px; right: 15px; }
        .louhan .tail { position: absolute; width: 0; height: 0; border-left: 18px solid #fd79a8; border-top: 12px solid transparent; border-bottom: 12px solid transparent; left: -15px; top: 8px; animation: tailWiggle 0.5s infinite alternate; }

        @keyframes swim { 0% { transform: translateX(-150px) scaleX(1); } 49% { transform: translateX(calc(100vw + 150px)) scaleX(1); } 50% { transform: translateX(calc(100vw + 150px)) scaleX(-1); } 99% { transform: translateX(-150px) scaleX(-1); } 100% { transform: translateX(-150px) scaleX(1); } }
        @keyframes tailWiggle { from { transform: rotate(-10deg); } to { transform: rotate(10deg); } }

        /* Corals & Seaweed */
        .coral { position: fixed; bottom: 0; left: 20px; width: 30px; height: 60px; background: linear-gradient(135deg, #e74c3c, #c0392b); border-radius: 15px 15px 0 0; animation: sway 3s infinite alternate; transform-origin: bottom; z-index: 0; pointer-events: none; }
        .coral::before { content: ''; position: absolute; width: 20px; height: 40px; background: #e74c3c; border-radius: 10px 10px 0 0; top: -20px; left: 5px; }
        .coral::after { content: ''; position: absolute; width: 15px; height: 30px; background: #c0392b; border-radius: 8px 8px 0 0; top: -15px; right: 5px; }
        .seaweed { position: fixed; bottom: 0; left: 70px; width: 20px; height: 70px; background: linear-gradient(135deg, #2ecc71, #27ae60); border-radius: 0 0 10px 10px; animation: sway 3.5s infinite alternate; transform-origin: bottom; z-index: 0; pointer-events: none; }
        .seaweed2 { left: 120px; height: 55px; width: 18px; animation-delay: 0.8s; background: linear-gradient(135deg, #27ae60, #1e8449); }
        .seaweed3 { right: 40px; left: auto; height: 80px; width: 25px; animation-delay: 1.2s; }
        .seaweed4 { right: 100px; left: auto; height: 45px; width: 15px; animation-delay: 0.4s; }
        .coral-right { right: 30px; left: auto; height: 50px; background: linear-gradient(135deg, #f39c12, #e67e22); }
        @keyframes sway { from { transform: rotate(-5deg); } to { transform: rotate(5deg); } }

        .light-ray { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(ellipse at 30% 0%, rgba(255,255,255,0.12) 0%, transparent 50%); pointer-events: none; z-index: 0; animation: lightMove 10s infinite alternate; }
        @keyframes lightMove { 0% { opacity: 0.3; transform: translateX(-5%); } 100% { opacity: 0.7; transform: translateX(5%); } }

        /* Container */
        .register-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; z-index: 2; padding: 40px 20px; }

        /* Card */
        .register-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); border-radius: 32px; box-shadow: 0 25px 50px rgba(0,0,0,0.3); width: 100%; max-width: 520px; overflow: hidden; animation: slideUp 0.6s ease-out; border: 1px solid rgba(255,255,255,0.4); }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        .card-header { background: linear-gradient(135deg, #0a4d6e, #006994); padding: 35px 30px; text-align: center; color: white; position: relative; overflow: hidden; }
        .card-header::before { content: '🐠🐟🐡🦈'; position: absolute; bottom: 5px; right: 15px; font-size: 40px; opacity: 0.15; }
        .card-header h2 { font-weight: 700; margin-bottom: 8px; font-size: 28px; position: relative; z-index: 1; }
        .card-header p { opacity: 0.8; font-size: 14px; position: relative; z-index: 1; }
        .icon-container { background: rgba(255,255,255,0.2); width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; animation: pulse 2s infinite; position: relative; z-index: 1; }
        @keyframes pulse { 0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255,255,255,0.4); } 70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(255,255,255,0); } 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255,255,255,0); } }
        .icon-container i { font-size: 32px; }

        /* Progress Steps */
        .progress-steps { display: flex; padding: 20px 30px; background: #e8f4f8; border-bottom: 1px solid #cbd5e0; }
        .step { flex: 1; text-align: center; position: relative; }
        .step-number { width: 35px; height: 35px; background: white; border: 2px solid #cbd5e0; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; color: #718096; transition: all 0.3s; }
        .step.active .step-number { background: linear-gradient(135deg, #0a4d6e, #006994); border-color: #0a4d6e; color: white; }
        .step.completed .step-number { background: #2ecc71; border-color: #2ecc71; color: white; }
        .step.completed .step-number i { font-size: 14px; }
        .step-label { font-size: 11px; margin-top: 6px; color: #718096; }
        .step.active .step-label { color: #0a4d6e; font-weight: 600; }

        .card-body { padding: 30px; }
        .form-step { display: none; animation: fadeIn 0.5s ease-out; }
        .form-step.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }

        .form-group { margin-bottom: 20px; }
        .form-label { font-weight: 600; margin-bottom: 8px; color: #0a4d6e; font-size: 14px; }
        .required { color: #e53e3e; }

        .input-group { border: 2px solid #e2e8f0; border-radius: 16px; transition: all 0.3s; background: white; }
        .input-group:focus-within { border-color: #0a4d6e; box-shadow: 0 0 0 3px rgba(10,77,110,0.1); }
        .input-group-text { background: transparent; border: none; color: #0a4d6e; padding: 12px 0 12px 16px; }
        .form-control { border: none; padding: 12px 16px 12px 0; font-size: 15px; background: transparent; }
        .form-control:focus { box-shadow: none; background: transparent; }

        .password-strength { margin-top: 8px; }
        .strength-bar { height: 4px; background: #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 5px; }
        .strength-fill { width: 0%; height: 100%; transition: width 0.3s; }
        .strength-text { font-size: 11px; color: #718096; }
        .strength-weak .strength-fill { width: 25%; background: #e53e3e; }
        .strength-medium .strength-fill { width: 50%; background: #ed8936; }
        .strength-strong .strength-fill { width: 75%; background: #38a169; }
        .strength-very-strong .strength-fill { width: 100%; background: #38a169; }

        .btn-primary-custom { background: linear-gradient(135deg, #0a4d6e, #006994); border: none; padding: 14px; border-radius: 16px; font-weight: 600; font-size: 16px; width: 100%; color: white; transition: all 0.3s; }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(10,77,110,0.4); }
        .btn-secondary-custom { background: #e2e8f0; border: none; padding: 14px; border-radius: 16px; font-weight: 600; font-size: 16px; width: 100%; color: #4a5568; transition: all 0.3s; }
        .btn-secondary-custom:hover { background: #cbd5e0; }

        .spinner { display: none; width: 20px; height: 20px; border: 2px solid white; border-top-color: transparent; border-radius: 50%; animation: spin 0.8s linear infinite; margin-right: 8px; }
        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 576px) {
            .card-header { padding: 25px 20px; }
            .card-body { padding: 20px; }
            .icon-container { width: 55px; height: 55px; }
            .icon-container i { font-size: 24px; }
            .card-header h2 { font-size: 24px; }
            .progress-steps { padding: 15px 20px; }
            .step-label { font-size: 9px; }
            .step-number { width: 28px; height: 28px; font-size: 12px; }
        }
    </style>
</head>
<body>
    <!-- Water Waves -->
    <div class="wave-bg"></div>
    <div class="wave-bg-2"></div>
    <div class="wave-bg-3"></div>

    <!-- Light Rays -->
    <div class="light-ray"></div>

    <!-- Corals & Seaweed -->
    <div class="coral"></div>
    <div class="seaweed"></div>
    <div class="seaweed seaweed2"></div>
    <div class="seaweed seaweed3"></div>
    <div class="seaweed seaweed4"></div>
    <div class="coral coral-right"></div>

    <div class="register-container">
        <div class="register-card">
            <div class="card-header">
                <div class="icon-container">
                    <i class="fas fa-fish"></i>
                </div>
                <h2>Create Account 🐠</h2>
                <p>Join our community today</p>
            </div>

            <div class="progress-steps">
                <div class="step active" id="step1Indicator"><div class="step-number">1</div><div class="step-label">Personal Info</div></div>
                <div class="step" id="step2Indicator"><div class="step-number">2</div><div class="step-label">Contact Info</div></div>
                <div class="step" id="step3Indicator"><div class="step-number">3</div><div class="step-label">Security</div></div>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4" style="border-radius: 16px;">
                        <i class="fas fa-exclamation-circle me-2"></i> Please fix the errors below.
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="form-step active" id="step1">
                        <div class="form-group">
                            <label class="form-label">Full Name <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" value="{{ old('name') }}" required>
                            </div>
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="yourname@company.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" name="phone" class="form-control" placeholder="08123456789" value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn-primary-custom" onclick="nextStep(2)">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <div class="form-step" id="step2">
                        <div class="form-group">
                            <label class="form-label">NIK (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="nik" class="form-control" placeholder="16 digit NIK" value="{{ old('nik') }}" maxlength="16">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">RT</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                        <input type="text" name="rt" class="form-control" placeholder="01" value="{{ old('rt') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">RW</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                        <input type="text" name="rw" class="form-control" placeholder="01" value="{{ old('rw') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <textarea name="address" class="form-control" rows="2" placeholder="Your address...">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn-secondary-custom" onclick="prevStep(1)"><i class="fas fa-arrow-left me-2"></i> Back</button>
                            <button type="button" class="btn-primary-custom" onclick="nextStep(3)">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <div class="form-step" id="step3">
                        <div class="form-group">
                            <label class="form-label">Password <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="regPassword" class="form-control" placeholder="Create a password" required>
                                <button type="button" class="input-group-text" id="toggleRegPassword" style="cursor: pointer;"><i class="fas fa-eye-slash"></i></button>
                            </div>
                            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                            <div class="password-strength" id="passwordStrength">
                                <div class="strength-bar"><div class="strength-fill"></div></div>
                                <div class="strength-text">Enter a strong password</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirm Password <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Confirm your password" required>
                                <button type="button" class="input-group-text" id="toggleConfirmPassword" style="cursor: pointer;"><i class="fas fa-eye-slash"></i></button>
                            </div>
                            <small id="passwordMatch" class="text-muted"></small>
                        </div>

                        <div class="alert alert-info mt-3" style="font-size: 12px; padding: 10px; border-radius: 12px; background: #e8f4f8; border: none; color: #0a4d6e;">
                            <i class="fas fa-info-circle me-2"></i> After registration, your account will be activated by admin.
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn-secondary-custom" onclick="prevStep(2)"><i class="fas fa-arrow-left me-2"></i> Back</button>
                            <button type="submit" class="btn-primary-custom" id="registerBtn">
                                <span class="spinner"></span>
                                <span class="btn-text">Create Account</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p style="font-size: 14px; color: #718096;">
                        Already have an account? <a href="{{ route('login') }}" class="text-link">Sign In</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        function showStep(step) {
            document.querySelectorAll('.form-step').forEach((el, idx) => { el.classList.remove('active'); if(idx + 1 === step) el.classList.add('active'); });
            for(let i = 1; i <= 3; i++) {
                const indicator = document.getElementById(`step${i}Indicator`);
                if(i < step) { indicator.classList.add('completed'); indicator.classList.remove('active'); indicator.querySelector('.step-number').innerHTML = '<i class="fas fa-check"></i>'; }
                else if(i === step) { indicator.classList.add('active'); indicator.classList.remove('completed'); indicator.querySelector('.step-number').innerHTML = i; }
                else { indicator.classList.remove('active', 'completed'); indicator.querySelector('.step-number').innerHTML = i; }
            }
            currentStep = step;
        }
        function nextStep(step) { showStep(step); }
        function prevStep(step) { showStep(step); }

        const regPassword = document.getElementById('regPassword');
        const strengthDiv = document.getElementById('passwordStrength');
        regPassword.addEventListener('input', function() {
            const val = this.value; let strength = 0;
            if(val.length >= 6) strength++;
            if(val.match(/[a-z]+/)) strength++;
            if(val.match(/[A-Z]+/)) strength++;
            if(val.match(/[0-9]+/)) strength++;
            if(val.match(/[$@#&!]+/)) strength++;
            strengthDiv.classList.remove('strength-weak', 'strength-medium', 'strength-strong', 'strength-very-strong');
            if(val.length === 0) strengthDiv.querySelector('.strength-text').innerHTML = 'Enter a strong password';
            else if(strength <= 2) { strengthDiv.classList.add('strength-weak'); strengthDiv.querySelector('.strength-text').innerHTML = 'Weak password'; }
            else if(strength === 3) { strengthDiv.classList.add('strength-medium'); strengthDiv.querySelector('.strength-text').innerHTML = 'Medium password'; }
            else if(strength === 4) { strengthDiv.classList.add('strength-strong'); strengthDiv.querySelector('.strength-text').innerHTML = 'Strong password'; }
            else { strengthDiv.classList.add('strength-very-strong'); strengthDiv.querySelector('.strength-text').innerHTML = 'Very strong password'; }
        });

        const confirmPassword = document.getElementById('confirmPassword');
        const passwordMatch = document.getElementById('passwordMatch');
        function checkPasswordMatch() {
            if(confirmPassword.value.length === 0) { passwordMatch.innerHTML = ''; passwordMatch.className = 'text-muted'; }
            else if(regPassword.value === confirmPassword.value) { passwordMatch.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i>Passwords match!'; passwordMatch.className = 'text-success'; }
            else { passwordMatch.innerHTML = '<i class="fas fa-times-circle text-danger me-1"></i>Passwords do not match!'; passwordMatch.className = 'text-danger'; }
        }
        regPassword.addEventListener('input', checkPasswordMatch);
        confirmPassword.addEventListener('input', checkPasswordMatch);

        document.getElementById('toggleRegPassword')?.addEventListener('click', function() {
            const type = regPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            regPassword.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        document.getElementById('toggleConfirmPassword')?.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        const registerForm = document.getElementById('registerForm');
        const registerBtn = document.getElementById('registerBtn');
        const spinner = registerBtn?.querySelector('.spinner');
        const btnText = registerBtn?.querySelector('.btn-text');
        registerForm?.addEventListener('submit', function(e) {
            if(regPassword.value !== confirmPassword.value) { e.preventDefault(); Swal.fire({ icon: 'error', title: 'Password Mismatch', text: 'Password and confirmation do not match!', confirmButtonColor: '#0a4d6e' }); return; }
            if(spinner && btnText) { spinner.style.display = 'inline-block'; btnText.textContent = ' Creating account...'; registerBtn.disabled = true; }
        });

        function createBubble() {
            const bubble = document.createElement('div');
            bubble.classList.add('bubble-bg');
            const size = Math.random() * 50 + 8;
            bubble.style.width = size + 'px';
            bubble.style.height = size + 'px';
            bubble.style.left = Math.random() * 100 + '%';
            bubble.style.animationDuration = Math.random() * 8 + 5 + 's';
            document.body.appendChild(bubble);
            setTimeout(() => bubble.remove(), 12000);
        }

        const fishTypes = ['clownfish', 'shark', 'koi', 'stingray', 'nemo', 'archer', 'puffer', 'louhan'];
        function createFish() {
            const fishDiv = document.createElement('div');
            fishDiv.classList.add('fish-bg');
            const randomFish = fishTypes[Math.floor(Math.random() * fishTypes.length)];
            fishDiv.classList.add(randomFish);
            fishDiv.style.top = Math.random() * 85 + 5 + '%';
            fishDiv.style.animationDuration = Math.random() * 15 + 15 + 's';
            if (randomFish === 'clownfish') { fishDiv.innerHTML = `<div class="clownfish"><div class="strip strip1"></div><div class="strip strip2"></div><div class="strip strip3"></div><div class="eye"></div><div class="tail"></div></div>`; }
            else if (randomFish === 'shark') { fishDiv.innerHTML = `<div class="shark"><div class="fin"></div><div class="fin2"></div><div class="eye"></div><div class="mouth"></div><div class="teeth"></div><div class="tail"></div></div>`; }
            else if (randomFish === 'koi') { fishDiv.innerHTML = `<div class="koi"><div class="spot spot1"></div><div class="spot spot2"></div><div class="spot spot3"></div><div class="eye"></div><div class="tail"></div></div>`; }
            else if (randomFish === 'stingray') { fishDiv.innerHTML = `<div class="stingray"><div class="wing"></div><div class="wing2"></div><div class="eye"></div><div class="tail-long"></div></div>`; }
            else if (randomFish === 'nemo') { fishDiv.innerHTML = `<div class="nemo"><div class="stripe stripe1"></div><div class="stripe stripe2"></div><div class="eye"></div><div class="tail"></div></div>`; }
            else if (randomFish === 'archer') { fishDiv.innerHTML = `<div class="archer"><div class="eye"></div><div class="tail"></div></div>`; }
            else if (randomFish === 'puffer') { fishDiv.innerHTML = `<div class="puffer"><div class="spike spike1"></div><div class="spike spike2"></div><div class="spike spike3"></div><div class="spike spike4"></div><div class="spike spike5"></div><div class="spike spike6"></div><div class="eye"></div><div class="mouth"></div></div>`; }
            else if (randomFish === 'louhan') { fishDiv.innerHTML = `<div class="louhan"><div class="head"></div><div class="eye"></div><div class="tail"></div></div>`; }
            document.body.appendChild(fishDiv);
            setTimeout(() => fishDiv.remove(), 35000);
        }

        setInterval(createBubble, 350);
        setInterval(createFish, 6000);
        for(let i = 0; i < 8; i++) setTimeout(() => createFish(), i * 2000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>aa
