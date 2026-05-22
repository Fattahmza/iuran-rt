@extends('layouts.app')

@section('header', 'Backup Data')
@section('subheader', 'Kelola backup database')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-database me-2 text-primary"></i>Data Backup</h5>
        <form action="{{ route('backup.store') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle me-2"></i>Buat Backup Baru</button>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead><tr><th>No</th><th>Nama File</th><th>Ukuran</th><th>Tanggal</th><th>Dibuat Oleh</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($backups ?? [] as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item->filename }}</td>
                        <td>{{ number_format($item->size / 1024, 2) }} KB</p>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</p>
                        <td>{{ $item->creator->name ?? '-' }}</p>
                        <td>
                            <a href="{{ route('backup.download', $item->id) }}" class="btn btn-success btn-sm"><i class="fas fa-download"></i></a>
                            <form action="{{ route('backup.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></button>
                            </form>
                         </p>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada backup data</p></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $backups->links() ?? '' }}
    </div>
</div>
@endsection
