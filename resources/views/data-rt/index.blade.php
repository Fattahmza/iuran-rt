@extends('layouts.app')

@section('header', 'Data RT')
@section('subheader', 'Informasi data RT')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-building me-2 text-primary"></i>Data RT</h5>
        @if(!$dataRT)
        <a href="{{ route('data-rt.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle me-2"></i>Tambah Data RT</a>
        @else
        <a href="{{ route('data-rt.edit', $dataRT->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-2"></i>Edit Data RT</a>
        @endif
    </div>
    <div class="card-body">
        @if($dataRT)
        <table class="table table-bordered">
            <tr><th style="width: 200px">Nama RT</th><td>{{ $dataRT->nama_rt ?? '-' }}</td></tr>
            <tr><th>Kode RT</th><td>{{ $dataRT->kode_rt ?? '-' }}</td></tr>
            <tr><th>RW</th><td>{{ $dataRT->rw ?? '-' }}</td></tr>
            <tr><th>Kelurahan</th><td>{{ $dataRT->kelurahan ?? '-' }}</td></tr>
            <tr><th>Kecamatan</th><td>{{ $dataRT->kecamatan ?? '-' }}</td></tr>
            <tr><th>Kota</th><td>{{ $dataRT->kota ?? '-' }}</td></tr>
            <tr><th>Provinsi</th><td>{{ $dataRT->provinsi ?? '-' }}</td></tr>
            <tr><th>Telepon</th><td>{{ $dataRT->telepon ?? '-' }}</td></tr>
            <tr><th>Email</th><td>{{ $dataRT->email ?? '-' }}</td></tr>
            <tr><th>Visi</th><td>{{ $dataRT->visi ?? '-' }}</td></tr>
            <tr><th>Misi</th><td>{{ $dataRT->misi ?? '-' }}</td></tr>
        </table>
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i> Belum ada data RT. Silakan tambah data RT.
        </div>
        @endif
    </div>
</div>
@endsection
