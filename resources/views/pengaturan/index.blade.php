@extends('layouts.app')

@section('header', 'Pengaturan')
@section('subheader', 'Pengaturan sistem dan data RT')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-cog me-2 text-primary"></i>Pengaturan Data RT</h5></div>
            <div class="card-body">
                <form action="{{ route('pengaturan.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Nama RT</label><input type="text" name="nama_rt" class="form-control" value="{{ $dataRT->nama_rt ?? '' }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Kode RT</label><input type="text" name="kode_rt" class="form-control" value="{{ $dataRT->kode_rt ?? '' }}"></div></div>
                    <div class="row"><div class="col-md-6 mb-3"><label class="form-label">RW</label><input type="text" name="rw" class="form-control" value="{{ $dataRT->rw ?? '' }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Kelurahan</label><input type="text" name="kelurahan" class="form-control" value="{{ $dataRT->kelurahan ?? '' }}"></div></div>
                    <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Kecamatan</label><input type="text" name="kecamatan" class="form-control" value="{{ $dataRT->kecamatan ?? '' }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Kota</label><input type="text" name="kota" class="form-control" value="{{ $dataRT->kota ?? '' }}"></div></div>
                    <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Provinsi</label><input type="text" name="provinsi" class="form-control" value="{{ $dataRT->provinsi ?? '' }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Telepon</label><input type="text" name="telepon" class="form-control" value="{{ $dataRT->telepon ?? '' }}"></div></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $dataRT->email ?? '' }}"></div>
                    <div class="mb-3"><label class="form-label">Visi</label><textarea name="visi" class="form-control" rows="3">{{ $dataRT->visi ?? '' }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Misi</label><textarea name="misi" class="form-control" rows="3">{{ $dataRT->misi ?? '' }}</textarea></div>
                    <div class="d-flex justify-content-end"><a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Batal</a><button type="submit" class="btn btn-primary">Simpan Pengaturan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
