@extends('layouts.app')

@section('header', 'Tambah Data RT')
@section('subheader', 'Tambah informasi data RT')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Form Tambah Data RT</h5></div>
            <div class="card-body">
                <form action="{{ route('data-rt.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Nama RT</label><input type="text" name="nama_rt" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Kode RT</label><input type="text" name="kode_rt" class="form-control" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">RW</label><input type="text" name="rw" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Kelurahan</label><input type="text" name="kelurahan" class="form-control" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Kecamatan</label><input type="text" name="kecamatan" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Kota</label><input type="text" name="kota" class="form-control" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Provinsi</label><input type="text" name="provinsi" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Telepon</label><input type="text" name="telepon" class="form-control"></div>
                    </div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Visi</label><textarea name="visi" class="form-control" rows="3"></textarea></div>
                    <div class="mb-3"><label class="form-label">Misi</label><textarea name="misi" class="form-control" rows="3"></textarea></div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('data-rt.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
