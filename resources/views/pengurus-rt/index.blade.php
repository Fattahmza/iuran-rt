@extends('layouts.app')

@section('header', 'Pengurus RT')
@section('subheader', 'Kelola data pengurus RT')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-user-tie me-2 text-primary"></i>Data Pengurus RT</h5>
        <a href="{{ route('pengurus-rt.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle me-2"></i>Tambah Pengurus</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light"><tr><th>No</th><th>Nama</th><th>Jabatan</th><th>Periode</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($pengurus ?? [] as $i => $item)
                    <tr><td>{{ $i+1 }}</td><td>{{ $item->user->name ?? '-' }}</td><td>{{ $item->jabatan }}</td><td>{{ $item->periode }}</td><td><a href="{{ route('pengurus-rt.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a><form action="{{ route('pengurus-rt.destroy', $item->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button></form></td></tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Belum ada data pengurus</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
