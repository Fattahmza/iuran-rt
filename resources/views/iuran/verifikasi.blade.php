@extends('layouts.app')

@section('header', 'Verifikasi Pembayaran')
@section('subheader', 'Verifikasi bukti pembayaran dari warga')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-clock me-2 text-warning"></i>Menunggu Verifikasi
                    <span class="badge bg-primary ms-2" id="totalData">{{ $pendingVerifikasi->total() }} Data</span>
                </h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Bayar</th>
                            <th>Nama Warga</th>
                            <th>Jenis Iuran</th>
                            <th>Jumlah</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($pendingVerifikasi as $item)
                        <tr id="row-{{ $item->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal_bayar->format('d/m/Y') }}</td>
                            <td>{{ $item->user->name ?? '-' }}<br><small>RT {{ $item->user->rt ?? '-' }}/RW {{ $item->user->rw ?? '-' }}</small></td>
                            <td>{{ $item->jenisIuran->nama ?? $item->jenis ?? '-' }}</td>
                            <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}@if($item->denda > 0)<br><small class="text-danger">Denda: Rp {{ number_format($item->denda, 0, ',', '.') }}</small>@endif</br>
                            <td>
                                @if($item->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                @else
                                    -
                                @endif
                             </br>
                            <td>
                                <form action="{{ route('iuran.proses.verifikasi', $item->id) }}" method="POST" onsubmit="return confirmVerifikasi(this)">
                                    @csrf
                                    <input type="hidden" name="verifikasi_status" value="verified">
                                    <input type="hidden" name="catatan_verifikasi" value="Diverifikasi">
                                    <button type="submit" class="btn btn-sm btn-success">✅ Verifikasi</button>
                                </form>
                             </br>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </div>

                {{ $pendingVerifikasi->links() }}
            </div>
        </div>
    </div>
</div>

<script>
function confirmVerifikasi(form) {
    if (confirm('Yakin verifikasi pembayaran ini?')) {
        const btn = form.querySelector('button');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '⏳ Proses...';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                verifikasi_status: 'verified',
                catatan_verifikasi: 'Diverifikasi'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hapus baris
                const row = form.closest('tr');
                row.remove();

                // Update total data
                const totalSpan = document.getElementById('totalData');
                const currentTotal = parseInt(totalSpan.innerText);
                totalSpan.innerText = (currentTotal - 1) + ' Data';

                // Tampilkan pesan
                alert('✅ ' + data.message);

                // Cek apakah masih ada data
                const tbody = document.getElementById('tableBody');
                if (tbody.children.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
                }
            } else {
                alert('❌ Gagal: ' + data.message);
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        })
        .catch(error => {
            alert('❌ Error: ' + error.message);
            btn.disabled = false;
            btn.innerHTML = originalText;
        });

        return false;
    }
    return false;
}
</script>
@endsection
