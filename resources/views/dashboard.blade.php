@extends('layouts.app')

@section('header', 'Dashboard')
@section('subheader', 'Selamat datang di Sistem Kas RT')

@section('content')
<style>
    /* Ikan di Tengah */
    .dashboard-center-fish {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 5;
        pointer-events: none;
        animation: dashboardRotateFish 25s linear infinite;
    }
    @keyframes dashboardRotateFish { 0% { transform: translate(-50%, -50%) rotate(0deg); } 100% { transform: translate(-50%, -50%) rotate(360deg); } }
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
            <div><h3 class="fw-bold mb-2"><i class="fas fa-fish me-2"></i> Halo, {{ auth()->user()->name }}!</h3><p class="mb-0 opacity-75">Kelola keuangan RT dengan mudah dan transparan</p></div>
            <div class="mt-2 mt-sm-0"><div class="bg-white bg-opacity-25 rounded-3 p-3"><small>Login sebagai</small><h5 class="mb-0">{{ auth()->user()->role->display_name ?? 'User' }}</h5></div></div>
        </div>
    </div>

    <!-- Row 1: Statistik Cards (4 card) -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-hover bg-success text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><small class="text-white-50">TOTAL PEMASUKAN</small><h3 class="fw-bold mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3><small>+{{ number_format($persenPemasukan,1) }}% dari bulan lalu</small></div>
                        <i class="fas fa-arrow-down fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-hover bg-danger text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><small class="text-white-50">TOTAL PENGELUARAN</small><h3 class="fw-bold mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3><small>+{{ number_format($persenPengeluaran,1) }}% dari bulan lalu</small></div>
                        <i class="fas fa-arrow-up fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-hover bg-primary text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><small class="text-white-50">SALDO KAS</small><h3 class="fw-bold mb-0">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3><small>Per {{ date('d M Y') }}</small></div>
                        <i class="fas fa-wallet fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-hover bg-info text-white border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><small class="text-white-50">TOTAL WARGA</small><h3 class="fw-bold mb-0">{{ number_format($totalWarga) }}</h3><small>KK Terdaftar</small></div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Grafik Kas Bulanan & Pengeluaran per Kategori -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card stat-card-hover h-100">
                <div class="card-header bg-white border-0 pt-4"><h5 class="fw-bold mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Grafik Kas Bulanan</h5></div>
                <div class="card-body"><canvas id="kasChart" height="280"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card stat-card-hover h-100">
                <div class="card-header bg-white border-0 pt-4"><h5 class="fw-bold mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>Pengeluaran per Kategori</h5></div>
                <div class="card-body">
                    <canvas id="kategoriChart" height="180"></canvas>
                    <div class="mt-3">
                        @forelse($pengeluaranPerKategori ?? [] as $k)
                        <div class="d-flex justify-content-between mb-2"><span><i class="{{ $k->icon ?? 'fas fa-tag' }} me-2"></i>{{ $k->name }}</span><span class="fw-bold">Rp {{ number_format($k->total ?? 0, 0, ',', '.') }}</span></div>
                        @empty
                        <p class="text-muted text-center py-3">Belum ada data pengeluaran</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Transaksi Terbaru & Pengumuman -->
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="card stat-card-hover h-100">
                <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="fw-bold mb-0"><i class="fas fa-history me-2 text-primary"></i>Transaksi Terbaru</h5>
                    <a href="{{ route('iuran.index') }}" class="btn btn-sm btn-link">Lihat semua <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th>Tanggal</th><th>Keterangan</th><th>Kategori</th><th class="text-end">Jumlah</th></td>
                            </thead>
                            <tbody>
                                @forelse($transaksiTerbaru ?? [] as $item)
                                <tr class="{{ $item->tipe == 'pemasukan' ? 'table-success' : 'table-danger' }}">
                                    <td>{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</p>
                                    <td>{{ $item->keterangan ?? ($item->tipe == 'pemasukan' ? 'Iuran Bulan ' . $item->bulan : 'Pengeluaran') }}</p>
                                    <td><span class="badge bg-{{ $item->kategori->color ?? 'secondary' }}">{{ $item->kategori->name ?? ($item->tipe == 'pemasukan' ? 'Iuran Warga' : 'Lainnya') }}</span></p>
                                    <td class="fw-bold text-end {{ $item->tipe == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                        {{ $item->tipe == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </p>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data transaksi</p></td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card stat-card-hover h-100">
                <div class="card-header bg-white border-0 pt-4"><h5 class="fw-bold mb-0"><i class="fas fa-bullhorn me-2 text-primary"></i>Pengumuman</h5></div>
                <div class="card-body">
                    @forelse($pengumumanTerbaru ?? [] as $p)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between flex-wrap"><h6 class="fw-bold mb-1">{{ $p->title }}</h6><small class="text-muted">{{ $p->date->format('d M Y') }}</small></div>
                        <p class="text-muted small mb-2">{{ Str::limit($p->content, 100) }}</p>
                        <small class="text-muted"><i class="fas fa-user me-1"></i> {{ $p->creator->name ?? 'Admin' }}</small>
                    </div>
                    @empty
                    <p class="text-muted text-center py-4">Belum ada pengumuman</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: Aksi Cepat -->
    <div class="row">
        <div class="col-12">
            <div class="card stat-card-hover">
                <div class="card-header bg-white border-0 pt-4"><h5 class="fw-bold mb-0"><i class="fas fa-bolt me-2 text-primary"></i>Aksi Cepat</h5></div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start">
                        <a href="{{ route('iuran.create') }}?tipe=pemasukan" class="btn btn-success btn-quick"><i class="fas fa-plus-circle me-2"></i>Tambah Pemasukan</a>
                        <a href="{{ route('iuran.create') }}?tipe=pengeluaran" class="btn btn-danger btn-quick"><i class="fas fa-minus-circle me-2"></i>Tambah Pengeluaran</a>
                        <a href="{{ route('warga.index') }}" class="btn btn-info btn-quick text-white"><i class="fas fa-users me-2"></i>Data Warga</a>
                        <a href="{{ route('iuran.laporan') }}" class="btn btn-primary btn-quick"><i class="fas fa-chart-line me-2"></i>Laporan Keuangan</a>
                        <a href="{{ route('iuran.export') }}" class="btn btn-secondary btn-quick"><i class="fas fa-file-excel me-2"></i>Export Excel</a>
                        <button class="btn btn-warning btn-quick" onclick="backupDatabase()"><i class="fas fa-database me-2"></i>Backup Data</button>
                    </div>
                </div>
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

    function backupDatabase() {
        Swal.fire({
            title: 'Backup Database',
            text: 'Fitur backup akan segera tersedia',
            icon: 'info',
            confirmButtonColor: '#0a4d6e'
        });
    }
</script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Kas Bulanan
    const monthlyData = @json($monthlyData);
    if (monthlyData.length > 0) {
        new Chart(document.getElementById('kasChart'), {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.bulan),
                datasets: [
                    { label: 'Pemasukan', data: monthlyData.map(d => d.pemasukan), borderColor: '#28a745', backgroundColor: 'rgba(40,167,69,0.1)', fill: true, tension: 0.4, pointBackgroundColor: '#28a745', pointBorderColor: '#fff', pointRadius: 5 },
                    { label: 'Pengeluaran', data: monthlyData.map(d => d.pengeluaran), borderColor: '#dc3545', backgroundColor: 'rgba(220,53,69,0.1)', fill: true, tension: 0.4, pointBackgroundColor: '#dc3545', pointBorderColor: '#fff', pointRadius: 5 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: true, plugins: { tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: Rp ${ctx.raw.toLocaleString('id-ID')}` } } }, scales: { y: { ticks: { callback: (v) => 'Rp ' + v.toLocaleString('id-ID') } } } }
        });
    }

    // Grafik Pengeluaran per Kategori
    const kategoriData = @json($pengeluaranPerKategori);
    if (kategoriData.length > 0) {
        new Chart(document.getElementById('kategoriChart'), {
            type: 'doughnut',
            data: { labels: kategoriData.map(k => k.name), datasets: [{ data: kategoriData.map(k => k.total), backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6f42c1', '#fd7e14', '#20c997'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } }, tooltip: { callbacks: { label: (ctx) => `${ctx.label}: Rp ${ctx.raw.toLocaleString('id-ID')}` } } } }
        });
    } else {
        const chartCanvas = document.getElementById('kategoriChart');
        if (chartCanvas) {
            chartCanvas.style.display = 'none';
            chartCanvas.insertAdjacentHTML('afterend', '<p class="text-center text-muted py-4">Belum ada data pengeluaran</p>');
        }
    }
</script>
@endpush
@endsection
