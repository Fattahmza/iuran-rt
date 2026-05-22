@extends('layouts.app')

@section('header', 'Iuran Warga')
@section('subheader', 'Kelola iuran wajib warga')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-hand-holding-usd me-2 text-primary"></i>Data Iuran Warga</h5>
        <a href="{{ route('iuran-warga.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle me-2"></i>Tambah Iuran</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light"><tr><th>No</th><th>Warga</th><th>Bulan</th><th>Tahun</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($iurans ?? [] as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>{{ $item->bulan }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td><span class="badge bg-{{ $item->status == 'lunas' ? 'success' : 'danger' }}">{{ $item->status }}</span></td>
                        <td>
                            <a href="{{ route('iuran-warga.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('iuran-warga.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Belum ada data iuran warga</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
