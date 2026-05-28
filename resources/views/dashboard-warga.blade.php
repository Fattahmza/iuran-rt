@extends('layouts.app')

@section('header', 'Dashboard Warga')
@section('subheader', 'Kelola pembayaran iuran Anda')

@section('content')
<style>
    .dashboard-center-fish {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 5;
        pointer-events: none;
        animation: dashboardRotateFish 25s linear infinite;
    }
    @keyframes dashboardRotateFish {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    .dashboard-big-fish {
        position: relative;
        width: 80px;
        height: 40px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        border-radius: 50%;
        opacity: 0.6;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .dashboard-big-fish .strip { position: absolute; width: 8px; height: 45px; background: white; top: -2px; border-radius: 4px; }
    .dashboard-big-fish .strip1 { left: 15px; transform: rotate(-5deg); }
    .dashboard-big-fish .strip2 { left: 35px; }
    .dashboard-big-fish .strip3 { left: 55px; transform: rotate(5deg); }
    .dashboard-big-fish .eye { position: absolute; width: 10px; height: 10px; background: white; border-radius: 50%; top: 9px; right: 15px; }
    .dashboard-big-fish .eye::after { content: ''; position: absolute; width: 5px; height: 5px; background: black; border-radius: 50%; top: 2px; right: 2px; }
    .dashboard-big-fish .tail { position: absolute; width: 0; height: 0; border-left: 20px solid #ee5a24; border-top: 14px solid transparent; border-bottom: 14px solid transparent; left: -18px; top: 6px; animation: dashboardTailWiggle 0.6s infinite alternate; }
    @keyframes dashboardTailWiggle { from { transform: rotate(-10deg); } to { transform: rotate(10deg); } }

    .dashboard-small-fish {
        position: fixed;
        width: 35px;
        height: 18px;
        background: linear-gradient(135deg, #feca57, #ff9f43);
        border-radius: 50%;
        animation: dashboardSwimFree 20s infinite linear;
        z-index: 5;
        pointer-events: none;
        opacity: 0.5;
    }
    .dashboard-small-fish .eye { position: absolute; width: 4px; height: 4px; background: white; border-radius: 50%; top: 4px; right: 7px; }
    .dashboard-small-fish .tail { position: absolute; width: 0; height: 0; border-left: 8px solid #ff9f43; border-top: 6px solid transparent; border-bottom: 6px solid transparent; left: -8px; top: 3px; animation: dashboardTailWiggle 0.3s infinite alternate; }
    .dashboard-green-fish {
        position: fixed;
        width: 30px;
        height: 15px;
        background: linear-gradient(135deg, #1dd1a1, #10ac84);
        border-radius: 50%;
        animation: dashboardSwimFree 18s infinite linear;
        z-index: 5;
        pointer-events: none;
        opacity: 0.5;
    }
    @keyframes dashboardSwimFree {
        0% { transform: translateX(-200px) scaleX(1); } 49% { transform: translateX(calc(100vw + 200px)) scaleX(1); }
        50% { transform: translateX(calc(100vw + 200px)) scaleX(-1); } 99% { transform: translateX(-200px) scaleX(-1); }
        100% { transform: translateX(-200px) scaleX(1); }
    }

    .dashboard-bubble {
        position: fixed;
        background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.5), rgba(255,255,255,0.1));
        border-radius: 50%;
        animation: dashboardBubbleFloat 12s infinite ease-in-out;
        z-index: 5;
        pointer-events: none;
    }
    @keyframes dashboardBubbleFloat {
        0% { transform: translateY(100vh) scale(0.3); opacity: 0; }
        20% { opacity: 0.5; } 80% { opacity: 0.5; }
        100% { transform: translateY(-20vh) scale(1); opacity: 0; }
    }

    .stat-card-hover { transition: transform 0.3s, box-shadow 0.3s; border: none; border-radius: 1rem; overflow: hidden; }
    .stat-card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
    .btn-quick { transition: all 0.3s; border-radius: 12px; padding: 10px 20px; font-weight: 500; }
    .btn-quick:hover { transform: translateY(-3px); }
    .welcome-section { background: linear-gradient(135deg, #0a4d6e, #006994); border-radius: 1.5rem; padding: 1.8rem; color: white; margin-bottom: 2rem; position: relative; overflow: hidden; }
    .welcome-section::before { content: '🐠🐟🐡🦈'; position: absolute; bottom: 10px; right: 20px; font-size: 50px; opacity: 0.1; }
</style>

<!-- Ikan di Tengah -->
<div class="dashboard-center-fish"><div class="dashboard-big-fish"><div class="strip strip1"></div><div class="strip strip2"></div><div class="strip strip3"></div><div class="eye"></div><div class="tail"></div></div></div>

<div class="dashboard-small-fish" style="top: 12%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="dashboard-small-fish" style="top: 28%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="dashboard-green-fish" style="top: 48%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="dashboard-small-fish" style="top: 68%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="dashboard-green-fish" style="top: 85%; left: 0;"><div class="eye"></div><div class="tail"></div></div>

<div class="fade-in-up" style="position: relative; z-index: 10;">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3 class="fw-bold mb-2"><i class="fas fa-fish me-2"></i> Halo, {{ auth()->user()->name }}!</h3>
                <p class="mb-0 opacity-75">Kelola pembayaran iuran Anda dengan mudah</p>
            </div>
            <div class="mt-2 mt-sm-0">
                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                    <small>Login sebagai</small>
                    <h5 class="mb-0">{{ auth()->user()->role->display_name ?? 'User' }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi Telat -->
    @if(($totalDenda ?? 0) > 0)
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" style="border-left: 5px solid #dc3545;">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <i class="fas fa-exclamation-triangle fa-2x me-3 float-start" style="color: #dc3545;"></i>
                <div>
                    <strong class="text-danger">⚠️ PERINGATAN!</strong> Anda memiliki tagihan yang <strong class="text-danger">telat dibayar</strong>!<br>
                    <small>Total denda: <strong class="text-danger">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</strong></small>
                </div>
            </div>
            <a href="#tagihan" class="btn btn-danger btn-sm mt-2 mt-sm-0">
                <i class="fas fa-eye me-1"></i> Lihat Tagihan
            </a>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card stat-card-hover bg-success text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50">TOTAL SUDAH BAYAR</small>
                            <h3 class="fw-bold mb-0">Rp {{ number_format($totalSudahBayar ?? 0, 0, ',', '.') }}</h3>
                            <small>{{ $riwayatPembayaran->total() }} transaksi</small>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card-hover bg-warning text-dark border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-dark-50">TOTAL BELUM BAYAR</small>
                            <h3 class="fw-bold mb-0">Rp {{ number_format($totalBelumBayar ?? 0, 0, ',', '.') }}</h3>
                            <small>{{ $tagihanBelumLunas->count() }} tagihan</small>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tagihan Belum Lunas -->
    <div class="card mb-4" id="tagihan">
        <div class="card-header bg-white border-0 pt-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-receipt me-2 text-warning"></i>Tagihan Belum Lunas</h5>
        </div>
        <div class="card-body">
            @if($tagihanBelumLunas->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Iuran</th>
                            <th>Bulan/Tahun</th>
                            <th>Jumlah</th>
                            <th>Batas Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tagihanBelumLunas as $i => $item)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $item->jenisLabel }}</td>
                            <td>{{ $item->bulan }} {{ $item->tahun }}</td>
                            <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if($item->jenisIuran)
                                    Tanggal {{ $item->jenisIuran->batas_tanggal }}
                                @else
                                    Tanggal 15
                                @endif
                            </td>
                            <td>
                                @if($item->isTerlambat())
                                    <span class="badge bg-danger">Telat {{ $item->hariTerlambat }} hari</span>
                                @else
                                    <span class="badge bg-warning">Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('iuran.create') }}?jenis_iuran_id={{ $item->jenis_iuran_id }}&bulan={{ $item->bulan }}&tahun={{ $item->tahun }}&jumlah={{ $item->jumlah }}"
                                   class="btn btn-success btn-sm">
                                    <i class="fas fa-credit-card me-1"></i> Bayar Sekarang
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4 text-muted">
                <i class="fas fa-check-circle fa-3x mb-2 d-block text-success"></i>
                Tidak ada tagihan, semua iuran sudah lunas!
            </div>
            @endif
        </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="card">
        <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><i class="fas fa-history me-2 text-primary"></i>Riwayat Pembayaran</h5>
            <a href="{{ route('iuran.index') }}" class="btn btn-sm btn-link">Lihat semua <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal Bayar</th>
                            <th>Jenis Iuran</th>
                            <th>Bulan/Tahun</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPembayaran as $item)
                        <tr>
                            <td>{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->jenisLabel }}</td>
                            <td>{{ $item->bulan }} {{ $item->tahun }}</td>
                            <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td><span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Lunas</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-3x mb-2 d-block"></i>
                                Belum ada riwayat pembayaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-center">
                {{ $riwayatPembayaran->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function createDashboardBubble() {
        const bubble = document.createElement('div');
        bubble.classList.add('dashboard-bubble');
        const size = Math.random() * 30 + 5;
        bubble.style.width = size + 'px';
        bubble.style.height = size + 'px';
        bubble.style.left = Math.random() * 100 + '%';
        bubble.style.animationDuration = Math.random() * 8 + 6 + 's';
        document.body.appendChild(bubble);
        setTimeout(() => bubble.remove(), 12000);
    }
    setInterval(createDashboardBubble, 500);
</script>
@endsection
