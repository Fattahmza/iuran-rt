@extends('layouts.app')

@section('header', 'Laporan Iuran')
@section('subheader', 'Laporan iuran warga')

@section('content')
<div class="card">
    <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-file-invoice me-2 text-primary"></i>Laporan Iuran Warga</h5></div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><label>Bulan</label><select name="bulan" class="form-select" id="filterBulan">@foreach($bulanList ?? [] as $bulan)<option value="{{ $bulan }}">{{ $bulan }}</option>@endforeach</select></div>
            <div class="col-md-3"><label>Tahun</label><select name="tahun" class="form-select" id="filterTahun">@foreach($tahunList ?? [] as $tahun)<option value="{{ $tahun }}">{{ $tahun }}</option>@endforeach</select></div>
            <div class="col-md-3"><label>Status</label><select name="status" class="form-select" id="filterStatus"><option value="">Semua</option><option value="lunas">Lunas</option><option value="belum">Belum</option></select></div>
            <div class="col-md-3"><label>&nbsp;</label><button class="btn btn-primary w-100" onclick="filterLaporan()"><i class="fas fa-filter me-2"></i>Filter</button></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><div class="alert alert-success">Total Iuran: Rp {{ number_format($totalIuran ?? 0, 0, ',', '.') }}</div></div>
            <div class="col-md-4"><div class="alert alert-info">Total Lunas: Rp {{ number_format($totalLunas ?? 0, 0, ',', '.') }}</div></div>
            <div class="col-md-4"><div class="alert alert-warning">Total Belum: Rp {{ number_format($totalBelum ?? 0, 0, ',', '.') }}</div></div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead><tr><th>No</th><th>Warga</th><th>Bulan</th><th>Tahun</th><th>Jumlah</th><th>Status</th><th>Tgl Bayar</th></tr></thead>
                <tbody>@forelse($iurans ?? [] as $i => $item)<tr><td>{{ $i+1 }}</td><td>{{ $item->user->name ?? '-' }}</td><td>{{ $item->bulan }}</td><td>{{ $item->tahun }}</td><td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td><td><span class="badge bg-{{ $item->status == 'lunas' ? 'success' : 'danger' }}">{{ $item->status }}</span></td><td>{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</td></tr>@empty<tr><td colspan="7" class="text-center">Belum ada data</td></tr>@endforelse</tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function filterLaporan() {
        let bulan = document.getElementById('filterBulan').value;
        let tahun = document.getElementById('filterTahun').value;
        let status = document.getElementById('filterStatus').value;
        window.location.href = "{{ route('laporan-iuran.index') }}?bulan=" + bulan + "&tahun=" + tahun + "&status=" + status;
    }
</script>
@endsection
