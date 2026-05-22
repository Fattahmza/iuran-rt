@extends('layouts.app')

@section('header', 'Tambah Kategori')
@section('subheader', 'Tambah kategori transaksi baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Form Tambah Kategori</h5></div>
            <div class="card-body">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-3"><label class="form-label">Nama Kategori</label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-select" required>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
