@extends('layouts.app')

@section('header', 'Edit Iuran')
@section('subheader', 'Edit data iuran yang sudah ada')

@section('content')
<style>
    /* Ikan di Tengah */
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
        opacity: 0.5;
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

    .page-big-fish .fin {
        position: absolute;
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-bottom: 14px solid #ee5a24;
        top: -10px;
        left: 25px;
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
        opacity: 0.4;
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

    .page-green-fish {
        position: fixed;
        width: 25px;
        height: 12px;
        background: linear-gradient(135deg, #1dd1a1, #10ac84);
        border-radius: 50%;
        animation: pageSwimFree 18s infinite linear;
        z-index: 5;
        pointer-events: none;
        opacity: 0.4;
    }

    .page-green-fish .eye {
        position: absolute;
        width: 3px;
        height: 3px;
        background: white;
        border-radius: 50%;
        top: 3px;
        right: 5px;
    }

    .page-green-fish .tail {
        position: absolute;
        width: 0;
        height: 0;
        border-left: 6px solid #10ac84;
        border-top: 4px solid transparent;
        border-bottom: 4px solid transparent;
        left: -6px;
        top: 2px;
        animation: pageTailWiggle 0.4s infinite alternate;
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
</style>

<!-- Ikan Besar di Tengah -->
<div class="page-center-fish">
    <div class="page-big-fish">
        <div class="strip strip1"></div>
        <div class="strip strip2"></div>
        <div class="strip strip3"></div>
        <div class="eye"></div>
        <div class="tail"></div>
        <div class="fin"></div>
    </div>
</div>

<!-- Ikan Kecil Berenang -->
<div class="page-small-fish" style="top: 10%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 25%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-green-fish" style="top: 50%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 75%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-green-fish" style="top: 90%; left: 0;"><div class="eye"></div><div class="tail"></div></div>

<div class="row justify-content-center" style="position: relative; z-index: 10;">
    <div class="col-md-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-edit me-2 text-warning"></i>Form Edit Iuran
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('iuran.update', $iuran->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Warga <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Pilih Warga</option>
                            @foreach($wargas ?? [] as $warga)
                            <option value="{{ $warga->id }}" {{ old('user_id', $iuran->user_id) == $warga->id ? 'selected' : '' }}>
                                {{ $warga->name }} - RT {{ $warga->rt ?? '-' }}/RW {{ $warga->rw ?? '-' }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Bulan <span class="text-danger">*</span></label>
                            <input type="text" name="bulan" class="form-control @error('bulan') is-invalid @enderror"
                                   value="{{ old('bulan', $iuran->bulan) }}" required>
                            @error('bulan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
                                   value="{{ old('tahun', $iuran->tahun) }}" required>
                            @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Transaksi <span class="text-danger">*</span></label>
                            <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                <option value="iuran_wajib" {{ old('jenis', $iuran->jenis) == 'iuran_wajib' ? 'selected' : '' }}>🟢 Iuran Wajib (Pemasukan)</option>
                                <option value="iuran_sukarela" {{ old('jenis', $iuran->jenis) == 'iuran_sukarela' ? 'selected' : '' }}>🟢 Iuran Sukarela (Pemasukan)</option>
                                <option value="denda" {{ old('jenis', $iuran->jenis) == 'denda' ? 'selected' : '' }}>🟡 Denda (Pemasukan)</option>
                                <option value="sumbangan" {{ old('jenis', $iuran->jenis) == 'sumbangan' ? 'selected' : '' }}>🟢 Sumbangan (Pemasukan)</option>
                                <option value="pengeluaran" {{ old('jenis', $iuran->jenis) == 'pengeluaran' ? 'selected' : '' }}>🔴 Pengeluaran (Kas Keluar)</option>
                            </select>
                            @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jumlah (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                   value="{{ old('jumlah', $iuran->jumlah) }}" required>
                            @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_bayar" class="form-control @error('tanggal_bayar') is-invalid @enderror"
                                   value="{{ old('tanggal_bayar', $iuran->tanggal_bayar ? $iuran->tanggal_bayar->format('Y-m-d') : date('Y-m-d')) }}" required>
                            @error('tanggal_bayar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="lunas" {{ old('status', $iuran->status) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="belum" {{ old('status', $iuran->status) == 'belum' ? 'selected' : '' }}>Belum</option>
                                <option value="pending" {{ old('status', $iuran->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan <span class="text-muted">(opsional)</span></label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                  rows="3" placeholder="Catatan tambahan...">{{ old('keterangan', $iuran->keterangan) }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="alert alert-info" id="infoAlert">
                        <i class="fas fa-info-circle me-2"></i>
                        <span id="infoText">Untuk pemasukan, pilih jenis Iuran Wajib/Sukarela/Denda/Sumbangan. Untuk pengeluaran, pilih jenis Pengeluaran.</span>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('iuran.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-gradient">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Create Bubbles
    function createPageBubble() {
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

    setInterval(createPageBubble, 500);

    // Update alert based on jenis selection
    const jenisSelect = document.getElementById('jenis');
    const infoAlert = document.getElementById('infoAlert');
    const infoText = document.getElementById('infoText');

    function updateFormByJenis() {
        const jenis = jenisSelect.value;

        if (jenis === 'pengeluaran') {
            infoAlert.className = 'alert alert-danger';
            infoText.innerHTML = '<strong>🔴 Mode Pengeluaran:</strong> Uang akan KELUAR dari kas desa.';
        } else if (jenis !== '') {
            infoAlert.className = 'alert alert-info';
            infoText.innerHTML = '<strong>🟢 Mode Pemasukan:</strong> Uang akan MASUK ke kas desa.';
        } else {
            infoAlert.className = 'alert alert-info';
            infoText.innerHTML = 'Pilih jenis transaksi terlebih dahulu.';
        }
    }

    jenisSelect.addEventListener('change', updateFormByJenis);

    if (jenisSelect.value) {
        updateFormByJenis();
    }
</script>
@endsection
