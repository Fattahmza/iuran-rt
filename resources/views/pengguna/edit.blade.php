@extends('layouts.app')

@section('header', 'Edit Pengguna')
@section('subheader', 'Edit data akun pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-edit me-2 text-warning"></i>Form Edit Pengguna</h5></div>
            <div class="card-body">
                <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3"><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-control" value="{{ $pengguna->name }}" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $pengguna->email }}" required></div>
                    <div class="mb-3"><label class="form-label">Password (kosongkan jika tidak diubah)</label><input type="password" name="password" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Role</label><select name="role_id" class="form-select" required>@foreach($roles ?? [] as $role)<option value="{{ $role->id }}" {{ $pengguna->role_id == $role->id ? 'selected' : '' }}>{{ $role->display_name }}</option>@endforeach</select></div>
                    <div class="d-flex justify-content-end"><a href="{{ route('pengguna.index') }}" class="btn btn-secondary me-2">Kembali</a><button type="submit" class="btn btn-primary">Update</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
