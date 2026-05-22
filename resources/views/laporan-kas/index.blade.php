@extends('layouts.app')

@section('header', 'Laporan Kas')
@section('subheader', 'Laporan arus kas')

@section('content')
<div class="card">
    <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-coins me-2 text-primary"></i>Laporan Kas</h5></div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4"><label>Dari Tanggal</label><input type="date" id="start_date" class="form-control" value="{{ $startDate ?? date('Y-m-01') }}"></div>
            <div class="col-md-4"><label>Sampai Tanggal</label><input type="date" id="end_date" class="form-control" value="{{ $endDate ?? date('Y-m-t') }}"></div>
            <div class="col-md-4"><label>&nbsp;</label><button class="btn btn-primary w-100" onclick="filterLaporan()"><i class="fas fa-filter me-2"></i>Filter</button></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><div class="alert alert-success">Total Pemasukan: Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</div></div>
            <div class="col-md-4"><div class="alert alert-danger">Total Pengeluaran: Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</div></div>
            <div class="col-md-4"><div class="alert alert-info">Saldo Akhir: Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}</div></div>
        </div>
        <h6>Pemasukan</h6>
        <table class="table table-bordered table-sm mb-4"><thead><tr><th>Tanggal</th><th>Keterangan</th><th>Jumlah</th></tr></thead><tbody>@forelse($pemasukan ?? [] as $item)<tr><td>{{ $item->tanggal_bayar->format('d/m/Y') }}</td><td>{{ $item->keterangan ?? '-' }}</td><td class="text-success">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td></tr>@empty<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>@endforelse</tbody></table>
        <h6>Pengeluaran</h6>
        <table class="table table-bordered table-sm"><thead><tr><th>Tanggal</th><th>Keterangan</th><th>Jumlah</th></tr></thead><tbody>@forelse($pengeluaran ?? [] as $item)<tr><td>{{ $item->tanggal_bayar->format('d/m/Y') }}</td><td>{{ $item->keterangan ?? '-' }}</td><td class="text-danger">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td></tr>@empty<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>@endforelse</tbody></table>
    </div>
</div>
<script>
    function filterLaporan() {
        let start = document.getElementById('start_date').value;
        let end = document.getElementById('end_date').value;
        window.location.href = "{{ route('laporan-kas.index') }}?start_date=" + start + "&end_date=" + end;
    }
</script>
@endsection
