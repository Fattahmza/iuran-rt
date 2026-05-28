@extends('layouts.app')

@section('header', 'Edit Jenis Iuran')
@section('subheader', 'Edit data jenis iuran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0"><i class="fas fa-edit me-2 text-warning"></i>Form Edit Jenis Iuran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('jenis-iuran.update', $jenisIuran->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Jenis Iuran <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                               required value="{{ old('nama', $jenisIuran->nama) }}">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon FontAwesome</label>
                            <input type="text" name="icon" class="form-control" value="{{ old('icon', $jenisIuran->icon) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Warna Badge</label>
                            <select name="color" class="form-select">
                                <option value="primary" {{ old('color', $jenisIuran->color) == 'primary' ? 'selected' : '' }}>Biru</option>
                                <option value="success" {{ old('color', $jenisIuran->color) == 'success' ? 'selected' : '' }}>Hijau</option>
                                <option value="danger" {{ old('color', $jenisIuran->color) == 'danger' ? 'selected' : '' }}>Merah</option>
                                <option value="warning" {{ old('color', $jenisIuran->color) == 'warning' ? 'selected' : '' }}>Kuning</option>
                                <option value="info" {{ old('color', $jenisIuran->color) == 'info' ? 'selected' : '' }}>Biru Muda</option>
                                <option value="secondary" {{ old('color', $jenisIuran->color) == 'secondary' ? 'selected' : '' }}>Abu-abu</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nominal Default</label>
                        <input type="number" name="nominal_default" class="form-control" value="{{ old('nominal_default', $jenisIuran->nominal_default) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $jenisIuran->deskripsi) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('jenis-iuran.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
