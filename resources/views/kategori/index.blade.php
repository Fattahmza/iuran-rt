@extends('layouts.app')

@section('header', 'Kategori Transaksi')
@section('subheader', 'Kelola kategori pemasukan dan pengeluaran')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-tags me-2 text-primary"></i>Data Kategori</h5>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle me-2"></i>Tambah Kategori</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light"><tr><th>No</th><th>Nama Kategori</th><th>Tipe</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($kategoris ?? [] as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td><span class="badge bg-{{ $item->type == 'pemasukan' ? 'success' : 'danger' }}">{{ $item->type == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}</span></td>
                        <td>
                            <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
