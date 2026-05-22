@extends('layouts.app')

@section('header', 'Tambah Pengurus RT')
@section('subheader', 'Tambah pengurus RT baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Form Tambah Pengurus</h5></div>
            <div class="card-body">
                <form action="{{ route('pengurus-rt.store') }}" method="POST">
                    @csrf
                    <div class="mb-3"><label class="form-label">User</label><select name="user_id" class="form-select" required>@foreach($users ?? [] as $user)<option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role->display_name ?? '-' }})</option>@endforeach</select></div>
                    <div class="mb-3"><label class="form-label">Jabatan</label><input type="text" name="jabatan" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Periode</label><input type="text" name="periode" class="form-control" placeholder="Contoh: 2024-2026" required></div>
                    <div class="mb-3"><label class="form-label">Tugas</label><textarea name="tugas" class="form-control" rows="3"></textarea></div>
                    <div class="d-flex justify-content-end"><a href="{{ route('pengurus-rt.index') }}" class="btn btn-secondary me-2">Kembali</a><button type="submit" class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
