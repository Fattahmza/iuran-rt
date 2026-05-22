@extends('layouts.app')

@section('header', 'Laporan Iuran')
@section('subheader', 'Laporan pemasukan dan pengeluaran iuran desa')

@section('content')
<div class="fade-in-up">
    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('iuran.laporan') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @foreach($bulanList ?? [] as $bulan)
                        <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList ?? [] as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50">TOTAL PEMASUKAN</small>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</h2>
                            <small>{{ $totalTransaksiPemasukan ?? 0 }} transaksi</small>
                        </div>
                        <i class="fas fa-arrow-down fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50">TOTAL PENGELUARAN</small>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</h2>
                            <small>{{ $totalTransaksiPengeluaran ?? 0 }} transaksi</small>
                        </div>
                        <i class="fas fa-arrow-up fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50">SALDO AKHIR</small>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}</h2>
                            <small>Pemasukan - Pengeluaran</small>
                        </div>
                        <i class="fas fa-wallet fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pemasukan per Bulan -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-calendar-alt me-2 text-success"></i>Pemasukan per Bulan
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Pemasukan</th>
                        </thead>
                    <tbody>
                        @forelse($iuranPerBulan ?? [] as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->bulan }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ number_format($item->count) }} transaksi</p>
                            <td class="fw-bold text-success">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada data pemasukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pengeluaran per Bulan -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-calendar-alt me-2 text-danger"></i>Pengeluaran per Bulan
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Keterangan</th>
                            <th>Total Pengeluaran</th>
                        </td>
                    </thead>
                    <tbody>
                        @forelse($pengeluaranPerBulan ?? [] as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->bulan }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="fw-bold text-danger">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada data pengeluaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Riwayat Pengeluaran Terbaru -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-history me-2 text-danger"></i>Riwayat Pengeluaran Terbaru
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengeluaranTerbaru ?? [] as $item)
                        <tr>
                            <td>{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</p>
                            <td>{{ $item->keterangan ?? '-' }}</p>
                            <td class="fw-bold text-danger">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</p>
                            <td>{{ $item->user->name ?? '-' }}</p>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada data pengeluaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Pemasukan per Jenis -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>Pemasukan per Jenis
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartJenisLaporan" height="250"></canvas>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Jenis</th>
                                    <th>Jumlah Transaksi</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $jenisMap = [
                                        'iuran_wajib' => 'Iuran Wajib',
                                        'iuran_sukarela' => 'Iuran Sukarela',
                                        'denda' => 'Denda',
                                        'sumbangan' => 'Sumbangan'
                                    ];
                                @endphp
                                @foreach($iuranPerJenis ?? [] as $item)
                                <tr>
                                    <td>{{ $jenisMap[$item->jenis] ?? $item->jenis }}</p>
                                    <td>{{ $item->count }} transaksi</p>
                                    <td class="fw-bold">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 10 Warga Pembayar -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-trophy me-2 text-warning"></i>Top 10 Warga Pembayar Terbanyak
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Rank</th>
                                    <th>Nama Warga</th>
                                    <th>Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topWarga ?? [] as $index => $warga)
                                <tr>
                                    <td>
                                        @if($index == 0) 🥇
                                        @elseif($index == 1) 🥈
                                        @elseif($index == 2) 🥉
                                        @else {{ $index+1 }}
                                        @endif
                                    </p>
                                    <td>{{ $warga->user->name ?? 'Unknown' }}</p>
                                    <td class="fw-bold text-success">Rp {{ number_format($warga->total ?? 0, 0, ',', '.') }}</p>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada data
                                    </p>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="text-center mt-4">
        <a href="{{ route('iuran.export', request()->all()) }}" class="btn btn-success btn-lg px-4 me-2">
            <i class="fas fa-file-excel me-2"></i>Export ke Excel
        </a>
        <a href="{{ route('iuran.export-pdf', request()->all()) }}" class="btn btn-danger btn-lg px-4">
            <i class="fas fa-file-pdf me-2"></i>Export ke PDF
        </a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxJenis = document.getElementById('chartJenisLaporan')?.getContext('2d');
    if(ctxJenis) {
        const jenisData = @json($iuranPerJenis ?? []);
        const jenisMap = {
            'iuran_wajib': 'Iuran Wajib',
            'iuran_sukarela': 'Iuran Sukarela',
            'denda': 'Denda',
            'sumbangan': 'Sumbangan'
        };
        const jenisLabels = jenisData.map(item => jenisMap[item.jenis] || item.jenis);
        const jenisValues = jenisData.map(item => item.total);

        new Chart(ctxJenis, {
            type: 'doughnut',
            data: {
                labels: jenisLabels,
                datasets: [{
                    data: jenisValues,
                    backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#6f42c1'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ctx.label + ': Rp ' + ctx.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection
