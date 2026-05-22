@extends('layouts.app')

@section('header', 'Tambah Transfer')
@section('subheader', 'Tambah data transfer baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Form Tambah Transfer</h5></div>
            <div class="card-body">
                <form action="{{ route('transfer.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Dari Warga</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Pilih Warga</option>
                            @foreach($wargas ?? [] as $warga)
                            <option value="{{ $warga->id }}">{{ $warga->name }} - RT {{ $warga->rt }}/RW {{ $warga->rw }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 100000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Transfer</label>
                        <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan transfer..."></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('transfer.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
