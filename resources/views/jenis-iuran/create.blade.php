@extends('layouts.app')

@section('header', 'Tambah Jenis Iuran')
@section('subheader', 'Buat jenis iuran baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Form Tambah Jenis Iuran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('jenis-iuran.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Jenis Iuran <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                   required placeholder="Contoh: Iuran Keamanan" value="{{ old('nama') }}">
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon FontAwesome</label>
                            <input type="text" name="icon" class="form-control" placeholder="fas fa-shield-alt" value="{{ old('icon', 'fas fa-tag') }}">
                            <small class="text-muted">Contoh: fas fa-shield-alt, fas fa-broom, fas fa-tools</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Warna Badge</label>
                            <select name="color" class="form-select">
                                <option value="primary" {{ old('color') == 'primary' ? 'selected' : '' }}>Biru</option>
                                <option value="success" {{ old('color') == 'success' ? 'selected' : '' }}>Hijau</option>
                                <option value="danger" {{ old('color') == 'danger' ? 'selected' : '' }}>Merah</option>
                                <option value="warning" {{ old('color') == 'warning' ? 'selected' : '' }}>Kuning</option>
                                <option value="info" {{ old('color') == 'info' ? 'selected' : '' }}>Biru Muda</option>
                                <option value="secondary" {{ old('color') == 'secondary' ? 'selected' : '' }}>Abu-abu</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nominal Default (Rp)</label>
                            <input type="number" name="nominal_default" class="form-control" placeholder="50000" value="{{ old('nominal_default') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Denda per Hari (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="denda_per_hari" class="form-control" placeholder="5000" value="{{ old('denda_per_hari', 5000) }}" required>
                            <small class="text-muted">Denda yang dikenakan setiap hari setelah batas tanggal</small>
                            @error('denda_per_hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batas Tanggal Bayar <span class="text-danger">*</span></label>
                            <select name="batas_tanggal" class="form-select" required>
                                @for($i=1; $i<=31; $i++)
                                <option value="{{ $i }}" {{ old('batas_tanggal', 15) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <small class="text-muted">Setelah tanggal ini, akan dikenakan denda per hari</small>
                            @error('batas_tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat tentang jenis iuran ini">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi Denda:</strong> Denda akan dihitung otomatis setelah melewati batas tanggal bayar.<br>
                        Contoh: Jika batas tanggal = 15, dan bayar tanggal 20, maka denda = 5 hari × denda per hari.
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('jenis-iuran.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
