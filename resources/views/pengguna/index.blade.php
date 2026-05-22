@extends('layouts.app')

@section('header', 'Pengguna')
@section('subheader', 'Kelola akun pengguna sistem')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-users-cog me-2 text-primary"></i>Data Pengguna</h5>
        <a href="{{ route('pengguna.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle me-2"></i>Tambah Pengguna</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light"><tr><th>No</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($users ?? [] as $i => $item)
                    <tr>
                        <td>{{ $users->firstItem() + $i }}</td>
                        <td>{{ $item->name }}</p>
                        <td>{{ $item->email }}</p>
                        <td><span class="badge bg-primary">{{ $item->role->display_name ?? '-' }}</span></p>
                        <td>
                            <a href="{{ route('pengguna.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            @if($item->id != auth()->id())
                            <form action="{{ route('pengguna.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                         </p>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Belum ada data pengguna</p></td>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
</div>
@endsection
