@extends('layouts.app')

@section('header', 'Profil Saya')
@section('subheader', 'Kelola informasi akun Anda')

@section('content')
<style>
    /* Ikan di Tengah untuk Halaman Profil */
    .page-center-fish {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 5;
        pointer-events: none;
        animation: pageRotateFish 25s linear infinite;
    }

    @keyframes pageRotateFish {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .page-big-fish {
        position: relative;
        width: 70px;
        height: 35px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        border-radius: 50%;
        opacity: 0.4;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .page-big-fish .strip {
        position: absolute;
        width: 7px;
        height: 40px;
        background: white;
        top: -2px;
        border-radius: 4px;
    }
    .page-big-fish .strip1 { left: 12px; transform: rotate(-5deg); }
    .page-big-fish .strip2 { left: 30px; }
    .page-big-fish .strip3 { left: 48px; transform: rotate(5deg); }

    .page-big-fish .eye {
        position: absolute;
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        top: 8px;
        right: 12px;
    }
    .page-big-fish .eye::after {
        content: '';
        position: absolute;
        width: 4px;
        height: 4px;
        background: black;
        border-radius: 50%;
        top: 2px;
        right: 2px;
    }

    .page-big-fish .tail {
        position: absolute;
        width: 0;
        height: 0;
        border-left: 18px solid #ee5a24;
        border-top: 12px solid transparent;
        border-bottom: 12px solid transparent;
        left: -15px;
        top: 5px;
        animation: pageTailWiggle 0.6s infinite alternate;
    }

    @keyframes pageTailWiggle {
        from { transform: rotate(-10deg); }
        to { transform: rotate(10deg); }
    }

    /* Ikan Kecil */
    .page-small-fish {
        position: fixed;
        width: 30px;
        height: 15px;
        background: linear-gradient(135deg, #feca57, #ff9f43);
        border-radius: 50%;
        animation: pageSwimFree 20s infinite linear;
        z-index: 5;
        pointer-events: none;
        opacity: 0.3;
    }

    .page-small-fish .eye {
        position: absolute;
        width: 4px;
        height: 4px;
        background: white;
        border-radius: 50%;
        top: 3px;
        right: 6px;
    }

    .page-small-fish .tail {
        position: absolute;
        width: 0;
        height: 0;
        border-left: 7px solid #ff9f43;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        left: -7px;
        top: 2px;
        animation: pageTailWiggle 0.3s infinite alternate;
    }

    @keyframes pageSwimFree {
        0% { transform: translateX(-200px) translateY(0) scaleX(1); }
        49% { transform: translateX(calc(100vw + 200px)) translateY(0) scaleX(1); }
        50% { transform: translateX(calc(100vw + 200px)) translateY(0) scaleX(-1); }
        99% { transform: translateX(-200px) translateY(0) scaleX(-1); }
        100% { transform: translateX(-200px) translateY(0) scaleX(1); }
    }

    /* Bubbles */
    .page-bubble {
        position: fixed;
        background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.5), rgba(255,255,255,0.1));
        border-radius: 50%;
        animation: pageBubbleFloat 12s infinite ease-in-out;
        z-index: 5;
        pointer-events: none;
    }

    @keyframes pageBubbleFloat {
        0% { transform: translateY(100vh) scale(0.3); opacity: 0; }
        20% { opacity: 0.5; }
        80% { opacity: 0.5; }
        100% { transform: translateY(-20vh) scale(1); opacity: 0; }
    }

    .info-box {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 5px;
    }

    /* Tombol kamera */
    .btn-camera {
        cursor: pointer;
        transition: all 0.3s;
        z-index: 100;
        position: relative;
    }

    .btn-camera:hover {
        transform: scale(1.05);
    }

    /* MODAL MANUAL - TIDAK GELAP */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999999;
        justify-content: center;
        align-items: center;
    }

    .custom-modal-content {
        background: white;
        border-radius: 20px;
        max-width: 500px;
        width: 90%;
        margin: auto;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .custom-modal-header {
        background: linear-gradient(135deg, #0a4d6e, #006994);
        color: white;
        padding: 15px 20px;
        border-radius: 20px 20px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-modal-header h5 {
        margin: 0;
    }

    .custom-modal-close {
        background: none;
        border: none;
        color: white;
        font-size: 28px;
        cursor: pointer;
        line-height: 1;
        padding: 0;
        margin: 0;
    }

    .custom-modal-close:hover {
        opacity: 0.8;
    }

    .custom-modal-body {
        padding: 30px;
        text-align: center;
    }

    .custom-modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #dee2e6;
        text-align: right;
        border-radius: 0 0 20px 20px;
    }

    .preview-avatar {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #0a4d6e;
        margin-bottom: 20px;
    }

    .btn-upload-custom {
        background: #0a4d6e;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        cursor: pointer;
        display: inline-block;
        border: none;
        font-size: 14px;
    }

    .btn-upload-custom:hover {
        background: #006994;
    }

    .btn-cancel-custom {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        cursor: pointer;
        margin-right: 10px;
    }

    .btn-submit-custom {
        background: #0a4d6e;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        cursor: pointer;
    }

    .btn-submit-custom:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .text-muted-small {
        display: block;
        margin-top: 10px;
        color: #6c757d;
        font-size: 12px;
    }
</style>

<!-- Ikan Besar di Tengah -->
<div class="page-center-fish">
    <div class="page-big-fish">
        <div class="strip strip1"></div>
        <div class="strip strip2"></div>
        <div class="strip strip3"></div>
        <div class="eye"></div>
        <div class="tail"></div>
    </div>
</div>

<!-- Ikan Kecil -->
<div class="page-small-fish" style="top: 10%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 30%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 60%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 85%; left: 0;"><div class="eye"></div><div class="tail"></div></div>

<div class="row" style="position: relative; z-index: 10;">
    <div class="col-md-4 mb-4">
        <!-- Card Foto Profil -->
        <div class="card text-center">
            <div class="card-body">
                <div class="position-relative d-inline-block mb-3">
                    <img id="mainAvatar" src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" alt="Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #4361ee;">
                    <!-- Tombol Upload Foto -->
                    <button type="button" class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 btn-camera" style="width: 35px; height: 35px;" onclick="openUploadModal()">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
                <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                <p class="text-muted mb-2">{{ Auth::user()->role->display_name ?? 'User' }}</p>
                <p class="text-muted small">{{ Auth::user()->email }}</p>
                <hr>
                <div class="text-start">
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-calendar-alt me-2"></i>Bergabung: {{ Auth::user()->created_at->format('d M Y') }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="fas fa-id-card me-2"></i>ID: {{ Auth::user()->id }}
                    </small>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-qrcode me-2"></i>NIK: {{ Auth::user()->nik ?? 'Belum diisi' }}
                    </small>
                </div>
            </div>
        </div>

        <!-- Card Statistik -->
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Statistik Akun</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Iuran</span>
                    <span class="fw-bold">{{ App\Models\Iuran::where('user_id', Auth::id())->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Bayar</span>
                    <span class="fw-bold text-success">Rp {{ number_format(App\Models\Iuran::where('user_id', Auth::id())->where('status', 'lunas')->sum('jumlah'), 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Belum Bayar</span>
                    <span class="fw-bold text-danger">{{ App\Models\Iuran::where('user_id', Auth::id())->where('status', 'belum')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                    <i class="fas fa-user me-2"></i>Informasi Pribadi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="kependudukan-tab" data-bs-toggle="tab" data-bs-target="#kependudukan" type="button" role="tab">
                    <i class="fas fa-id-card me-2"></i>Data Kependudukan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                    <i class="fas fa-lock me-2"></i>Ganti Password
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="danger-tab" data-bs-toggle="tab" data-bs-target="#danger" type="button" role="tab">
                    <i class="fas fa-exclamation-triangle me-2"></i>Hapus Akun
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Tab Informasi Pribadi -->
            <div class="tab-pane fade show active" id="info" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0"><i class="fas fa-user-edit me-2 text-primary"></i>Edit Profil</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">No Handphone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Alamat</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', Auth::user()->address) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">RT</label>
                                    <input type="text" name="rt" class="form-control" value="{{ old('rt', Auth::user()->rt) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">RW</label>
                                    <input type="text" name="rw" class="form-control" value="{{ old('rw', Auth::user()->rw) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Bio / Deskripsi Singkat</label>
                                    <textarea name="bio" class="form-control" rows="2" placeholder="Tuliskan sedikit tentang diri Anda...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-gradient">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab Data Kependudukan -->
            <div class="tab-pane fade" id="kependudukan" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0"><i class="fas fa-id-card me-2 text-primary"></i>Data Kependudukan</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update.kependudukan') }}">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                           value="{{ old('nik', Auth::user()->nik) }}" placeholder="16 digit angka" maxlength="16">
                                    <small class="text-muted">NIK harus 16 digit angka</small>
                                    @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', Auth::user()->tempat_lahir) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', Auth::user()->tanggal_lahir ? Auth::user()->tanggal_lahir->format('Y-m-d') : '') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select">
                                        <option value="">Pilih</option>
                                        <option value="L" {{ old('jenis_kelamin', Auth::user()->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', Auth::user()->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', Auth::user()->pekerjaan) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Agama</label>
                                    <select name="agama" class="form-select">
                                        <option value="">Pilih</option>
                                        <option value="Islam" {{ old('agama', Auth::user()->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama', Auth::user()->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama', Auth::user()->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama', Auth::user()->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama', Auth::user()->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('agama', Auth::user()->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status Perkawinan</label>
                                    <select name="status_perkawinan" class="form-select">
                                        <option value="">Pilih</option>
                                        <option value="Belum Kawin" {{ old('status_perkawinan', Auth::user()->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="Kawin" {{ old('status_perkawinan', Auth::user()->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="Cerai Hidup" {{ old('status_perkawinan', Auth::user()->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('status_perkawinan', Auth::user()->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Data kependudukan ini digunakan untuk administrasi desa.</small>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-gradient">
                                    <i class="fas fa-save me-2"></i>Simpan Data Kependudukan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab Ganti Password -->
            <div class="tab-pane fade" id="password" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0"><i class="fas fa-key me-2 text-warning"></i>Ganti Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.password') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="form-label fw-bold">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Password minimal 6 karakter.
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-sync-alt me-2"></i>Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab Hapus Akun -->
            <div class="tab-pane fade" id="danger" role="tabpanel">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="fw-bold mb-0"><i class="fas fa-trash-alt me-2"></i>Hapus Akun</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Peringatan!</strong> Menghapus akun akan menghapus semua data Anda secara permanen.
                        </div>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <div class="mb-3">
                                <label class="form-label fw-bold">Konfirmasi Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password Anda untuk konfirmasi" required>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini? Data tidak dapat dikembalikan!')">
                                    <i class="fas fa-trash-alt me-2"></i>Hapus Akun Permanen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL MANUAL - TIDAK GELAP & BISA DIKLIK -->
<div id="avatarModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5><i class="fas fa-camera me-2"></i>Ganti Foto Profil</h5>
            <button type="button" class="custom-modal-close" onclick="closeUploadModal()">&times;</button>
        </div>
        <form method="POST" action="{{ route('profile.update.avatar') }}" enctype="multipart/form-data" id="avatarForm">
            @csrf
            @method('PATCH')
            <div class="custom-modal-body">
                <img id="avatarPreview" src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" class="preview-avatar">
                <div>
                    <label for="avatarInput" class="btn-upload-custom">
                        <i class="fas fa-folder-open me-2"></i>Pilih File
                    </label>
                    <input type="file" name="avatar" id="avatarInput" style="display: none;" accept="image/jpeg,image/png,image/jpg,image/gif">
                    <small class="text-muted-small">Format: JPG, PNG, GIF (Max 2MB)</small>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn-cancel-custom" onclick="closeUploadModal()">Batal</button>
                <button type="submit" class="btn-submit-custom" id="submitAvatarBtn">Upload Foto</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Membuat Bubbles
    function createProfileBubble() {
        const bubble = document.createElement('div');
        bubble.classList.add('page-bubble');
        const size = Math.random() * 30 + 5;
        bubble.style.width = size + 'px';
        bubble.style.height = size + 'px';
        bubble.style.left = Math.random() * 100 + '%';
        bubble.style.animationDuration = Math.random() * 8 + 6 + 's';
        document.body.appendChild(bubble);
        setTimeout(() => bubble.remove(), 12000);
    }
    setInterval(createProfileBubble, 500);

    // ========== FUNGSI MODAL MANUAL ==========
    function openUploadModal() {
        var modal = document.getElementById('avatarModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Reset preview ke gambar lama
        var mainAvatar = document.getElementById('mainAvatar');
        var avatarPreview = document.getElementById('avatarPreview');
        if (mainAvatar && avatarPreview) {
            avatarPreview.src = mainAvatar.src;
        }

        // Reset input file
        var avatarInput = document.getElementById('avatarInput');
        if (avatarInput) {
            avatarInput.value = '';
        }

        // Reset tombol submit
        var submitBtn = document.getElementById('submitAvatarBtn');
        if (submitBtn) {
            submitBtn.innerHTML = 'Upload Foto';
            submitBtn.disabled = false;
        }
    }

    function closeUploadModal() {
        var modal = document.getElementById('avatarModal');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Preview avatar sebelum upload
    var avatarInput = document.getElementById('avatarInput');
    var avatarPreview = document.getElementById('avatarPreview');
    var mainAvatar = document.getElementById('mainAvatar');

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                // Validasi tipe file
                var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Didukung',
                        text: 'Hanya file JPG, PNG, GIF yang diperbolehkan!',
                        confirmButtonColor: '#0a4d6e'
                    });
                    this.value = '';
                    return false;
                }

                // Validasi ukuran file (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran Terlalu Besar',
                        text: 'Maksimal ukuran file adalah 2MB!',
                        confirmButtonColor: '#0a4d6e'
                    });
                    this.value = '';
                    return false;
                }

                var reader = new FileReader();
                reader.onload = function(event) {
                    avatarPreview.src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Loading state saat submit
    var avatarForm = document.getElementById('avatarForm');
    var submitBtn = document.getElementById('submitAvatarBtn');

    if (avatarForm) {
        avatarForm.addEventListener('submit', function() {
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';
                submitBtn.disabled = true;
            }
        });
    }

    // Tutup modal jika klik di luar area konten
    window.onclick = function(event) {
        var modal = document.getElementById('avatarModal');
        if (event.target === modal) {
            closeUploadModal();
        }
    }

    // Tombol ESC untuk menutup modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            var modal = document.getElementById('avatarModal');
            if (modal.style.display === 'flex') {
                closeUploadModal();
            }
        }
    });
</script>
@endsection
