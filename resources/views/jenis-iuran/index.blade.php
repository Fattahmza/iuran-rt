@extends('layouts.app')

@section('header', 'Buat Iuran Baru')
@section('subheader', 'Kelola jenis-jenis iuran yang tersedia')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-tags me-2 text-primary"></i>Jenis Iuran</h5>
        <a href="{{ route('jenis-iuran.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Jenis Iuran
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Icon</th>
                        <th>Nama Jenis Iuran</th>
                        <th>Nominal Default</th>
                        <th>Denda/Hari</th>
                        <th>Batas Tgl</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisIurans ?? [] as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td><i class="{{ $item->icon }} fa-2x text-{{ $item->color }}"></i></td>
                        <td>
                            <strong>{{ $item->nama }}</strong><br>
                            <small class="text-muted">{{ $item->deskripsi ?? '-' }}</small>
                        </td>
                        <td>Rp {{ number_format($item->nominal_default ?? 0, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->denda_per_hari ?? 0, 0, ',', '.') }} <small class="text-muted">/hari</small></td>
                        <td>Tanggal {{ $item->batas_tanggal ?? 15 }}</td>
                        <td>
                            @if($item->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('jenis-iuran.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jenis-iuran.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus jenis iuran ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada jenis iuran. Silakan tambah jenis iuran baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
