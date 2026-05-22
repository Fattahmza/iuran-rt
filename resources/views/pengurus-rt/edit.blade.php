@extends('layouts.app')

@section('header', 'Edit Pengurus RT')
@section('subheader', 'Edit data pengurus RT')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="fw-bold mb-0"><i class="fas fa-edit me-2 text-warning"></i>Form Edit Pengurus</h5></div>
            <div class="card-body">
                <form action="{{ route('pengurus-rt.update', $pengurusRt->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3"><label class="form-label">Jabatan</label><input type="text" name="jabatan" class="form-control" value="{{ $pengurusRt->jabatan }}" required></div>
                    <div class="mb-3"><label class="form-label">Periode</label><input type="text" name="periode" class="form-control" value="{{ $pengurusRt->periode }}" required></div>
                    <div class="mb-3"><label class="form-label">Tugas</label><textarea name="tugas" class="form-control" rows="3">{{ $pengurusRt->tugas }}</textarea></div>
                    <div class="d-flex justify-content-end"><a href="{{ route('pengurus-rt.index') }}" class="btn btn-secondary me-2">Kembali</a><button type="submit" class="btn btn-primary">Update</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
