@extends('layouts.app')

@section('header', 'Tambah Pengguna')
@section('subheader', 'Tambah akun pengguna baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-user-plus me-2 text-primary"></i>Form Tambah Pengguna</h5></div>
            <div class="card-body">
                <form action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    <div class="mb-3"><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Role</label><select name="role_id" class="form-select" required>@foreach($roles ?? [] as $role)<option value="{{ $role->id }}">{{ $role->display_name }}</option>@endforeach</select></div>
                    <div class="d-flex justify-content-end"><a href="{{ route('pengguna.index') }}" class="btn btn-secondary me-2">Kembali</a><button type="submit" class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
