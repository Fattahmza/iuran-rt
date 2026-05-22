@extends('layouts.app')

@section('header', 'Tambah Iuran Warga')
@section('subheader', 'Tambah iuran warga baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Form Tambah Iuran Warga</h5></div>
            <div class="card-body">
                <form action="{{ route('iuran-warga.store') }}" method="POST">
                    @csrf
                    <div class="mb-3"><label class="form-label">Warga</label><select name="user_id" class="form-select" required>@foreach($wargas ?? [] as $warga)<option value="{{ $warga->id }}">{{ $warga->name }}</option>@endforeach</select></div>
                    <div class="mb-3"><label class="form-label">Bulan</label><select name="bulan" class="form-select" required>@foreach($bulanList ?? [] as $bulan)<option value="{{ $bulan }}">{{ $bulan }}</option>@endforeach</select></div>
                    <div class="mb-3"><label class="form-label">Tahun</label><input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required></div>
                    <div class="mb-3"><label class="form-label">Jumlah (Rp)</label><input type="number" name="jumlah" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="lunas">Lunas</option><option value="belum">Belum</option></select></div>
                    <div class="mb-3"><label class="form-label">Tanggal Bayar</label><input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}"></div>
                    <div class="d-flex justify-content-end"><a href="{{ route('iuran-warga.index') }}" class="btn btn-secondary me-2">Kembali</a><button type="submit" class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
