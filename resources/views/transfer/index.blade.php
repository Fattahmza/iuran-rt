@extends('layouts.app')

@section('header', 'Transfer')
@section('subheader', 'Kelola data transfer antar warga')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-random me-2 text-primary"></i>Data Transfer</h5>
        <a href="{{ route('transfer.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle me-2"></i>Tambah Transfer</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light"><tr><th>No</th><th>Tanggal</th><th>Dari Warga</th><th>Jumlah</th><th>Keterangan</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($transfers ?? [] as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td class="fw-bold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td>
                            <form action="{{ route('transfer.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada data transfer</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $transfers->links() ?? '' }}
    </div>
</div>
@endsection
