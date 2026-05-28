@extends('layouts.app')

@section('header', 'Data Warga')
@section('subheader', 'Kelola data warga desa')

@section('content')
<style>
    .page-center-fish {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 5;
        pointer-events: none;
        animation: pageRotateFish 25s linear infinite;
    }
    @keyframes pageRotateFish {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    .page-big-fish {
        position: relative;
        width: 70px;
        height: 35px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        opacity: 0.5;
    }
    .page-big-fish .strip { position: absolute; width: 7px; height: 40px; background: white; top: -2px; border-radius: 4px; }
    .page-big-fish .strip1 { left: 12px; transform: rotate(-5deg); }
    .page-big-fish .strip2 { left: 30px; }
    .page-big-fish .strip3 { left: 48px; transform: rotate(5deg); }
    .page-big-fish .eye { position: absolute; width: 8px; height: 8px; background: white; border-radius: 50%; top: 8px; right: 12px; }
    .page-big-fish .eye::after { content: ''; position: absolute; width: 4px; height: 4px; background: black; border-radius: 50%; top: 2px; right: 2px; }
    .page-big-fish .tail { position: absolute; width: 0; height: 0; border-left: 18px solid #ee5a24; border-top: 12px solid transparent; border-bottom: 12px solid transparent; left: -15px; top: 5px; animation: pageTailWiggle 0.6s infinite alternate; }
    @keyframes pageTailWiggle { from { transform: rotate(-10deg); } to { transform: rotate(10deg); } }
    
    .page-small-fish {
        position: fixed; width: 30px; height: 15px; background: linear-gradient(135deg, #feca57, #ff9f43);
        border-radius: 50%; animation: pageSwimFree 20s infinite linear; z-index: 5; pointer-events: none; opacity: 0.4;
    }
    .page-small-fish .eye { position: absolute; width: 4px; height: 4px; background: white; border-radius: 50%; top: 3px; right: 6px; }
    .page-small-fish .tail { position: absolute; width: 0; height: 0; border-left: 7px solid #ff9f43; border-top: 5px solid transparent; border-bottom: 5px solid transparent; left: -7px; top: 2px; animation: pageTailWiggle 0.3s infinite alternate; }
    .page-green-fish {
        position: fixed; width: 25px; height: 12px; background: linear-gradient(135deg, #1dd1a1, #10ac84);
        border-radius: 50%; animation: pageSwimFree 18s infinite linear; z-index: 5; pointer-events: none; opacity: 0.4;
    }
    @keyframes pageSwimFree {
        0% { transform: translateX(-200px) scaleX(1); } 49% { transform: translateX(calc(100vw + 200px)) scaleX(1); }
        50% { transform: translateX(calc(100vw + 200px)) scaleX(-1); } 99% { transform: translateX(-200px) scaleX(-1); }
        100% { transform: translateX(-200px) scaleX(1); }
    }
    .page-bubble {
        position: fixed; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.5), rgba(255,255,255,0.1));
        border-radius: 50%; animation: pageBubbleFloat 12s infinite ease-in-out; z-index: 5; pointer-events: none;
    }
    @keyframes pageBubbleFloat {
        0% { transform: translateY(100vh) scale(0.3); opacity: 0; }
        20% { opacity: 0.5; } 80% { opacity: 0.5; }
        100% { transform: translateY(-20vh) scale(1); opacity: 0; }
    }
    .info-box { background: #f8f9fa; padding: 8px 12px; border-radius: 10px; margin-bottom: 5px; }
    .btn-action { padding: 0.25rem 0.6rem; margin: 0 2px; }
    .text-purple { color: #6f42c1; }
    .table th { white-space: nowrap; }
    .table td { vertical-align: middle; }
</style>

<!-- Ikan di Tengah -->
<div class="page-center-fish">
    <div class="page-big-fish">
        <div class="strip strip1"></div><div class="strip strip2"></div><div class="strip strip3"></div>
        <div class="eye"></div><div class="tail"></div>
    </div>
</div>

<div class="page-small-fish" style="top: 10%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 25%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-green-fish" style="top: 50%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 75%; left: 0;"><div class="eye"></div><div class="tail"></div></div>

<div class="card fade-in-up" style="position: relative; z-index: 10;">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-primary"></i>Data Warga</h5>
        <a href="{{ route('warga.create') }}" class="btn btn-gradient btn-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Warga
        </a>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('warga.index') }}" class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, email, NIK, RT/RW..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Cari
                </button>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="8%">Foto</th>
                        <th width="15%">NIK</th>
                        <th width="15%">Nama</th>
                        <th width="10%">Jenis Kelamin</th>
                        <th width="15%">Email</th>
                        <th width="10%">No HP</th>
                        <th width="8%">RT/RW</th>
                        <th width="12%">Total Iuran</th>
                        <th width="12%">Belum Lunas</th>
                        <th width="10%">Aksi</th>
                    </td>
                </thead>
                <tbody>
                    @forelse($wargas ?? [] as $i => $item)
                    @php
                        $totalBayar = App\Models\Iuran::where('user_id', $item->id)->where('status', 'lunas')->sum('jumlah');
                        $totalTransaksi = App\Models\Iuran::where('user_id', $item->id)->count();
                        $belumLunas = App\Models\Iuran::where('user_id', $item->id)->where('status', 'belum')->count();
                        $telatBayar = App\Models\Iuran::where('user_id', $item->id)
                            ->where('status', '!=', 'lunas')
                            ->get()
                            ->filter(fn($iuran) => $iuran->isTerlambat())
                            ->count();
                    @endphp
                    <tr>
                        <td class="fw-bold text-center">{{ $wargas->firstItem() + $i }}</td>
                        <!-- Foto -->
                        <td class="text-center">
                            <img src="{{ $item->avatar_thumb ?? 'https://ui-avatars.com/api/?background=0a4d6e&color=fff&name='.urlencode($item->name) }}" 
                                 class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        </td>
                        <!-- NIK -->
                        <td>{{ $item->nik ?? '-' }}</td>
                        <!-- Nama -->
                        <td>
                            <div class="d-flex flex-column">
                                <strong>{{ $item->name }}</strong>
                                <small class="text-muted">{{ $item->role->display_name ?? 'Warga' }}</small>
                            </div>
                        </td>
                        <!-- Jenis Kelamin -->
                        <td class="text-center">
                            @if($item->jenis_kelamin == 'L')
                                <span class="badge bg-primary"><i class="fas fa-mars me-1"></i> Laki-laki</span>
                            @elseif($item->jenis_kelamin == 'P')
                                <span class="badge bg-danger"><i class="fas fa-venus me-1"></i> Perempuan</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <!-- Email -->
                        <td>{{ $item->email }}</td>
                        <!-- No HP -->
                        <td>{{ $item->phone ?? '-' }}</td>
                        <!-- RT/RW -->
                        <td class="text-center">RT {{ $item->rt ?? '-' }}/RW {{ $item->rw ?? '-' }}</td>
                        <!-- Total Iuran -->
                        <td>
                            <span class="badge bg-info">{{ $totalTransaksi }} transaksi</span><br>
                            <small class="text-success">Rp {{ number_format($totalBayar, 0, ',', '.') }}</small>
                        </td>
                        <!-- Belum Lunas -->
                        <td>
                            @if($belumLunas > 0)
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i> {{ $belumLunas }} iuran
                                </span>
                                @if($telatBayar > 0)
                                    <br>
                                    <span class="badge bg-danger mt-1">
                                        <i class="fas fa-exclamation-triangle me-1"></i> {{ $telatBayar }} telat
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Semua Lunas
                                </span>
                            @endif
                        </td>
                        <!-- Aksi -->
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('warga.edit', $item->id) }}" class="btn btn-warning btn-sm btn-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-info btn-sm btn-action" title="Lihat Profil" data-bs-toggle="modal" data-bs-target="#viewWargaModal" 
                                        onclick="viewWarga({{ json_encode($item) }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('iuran.index', ['user_id' => $item->id, 'status' => 'belum']) }}" class="btn btn-danger btn-sm btn-action" title="Iuran Belum Lunas">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <button type="button" class="btn btn-danger btn-sm btn-action" onclick="confirmDelete({{ $item->id }})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('warga.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Belum ada data warga
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 d-flex justify-content-center">
            {{ $wargas->withQueryString()->links() }}
        </div>
    </div>
</div>

<!-- Modal Lihat Profil Warga -->
<div class="modal fade" id="viewWargaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0a4d6e, #006994); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-circle me-2"></i>Detail Profil Warga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img id="modalAvatar" src="" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #0a4d6e;">
                    <h4 id="modalName" class="mt-3 mb-1"></h4>
                    <span class="badge bg-primary" id="modalRole">Warga</span>
                </div>
                <div class="row g-3">
                    <div class="col-12"><div class="info-box"><i class="fas fa-id-card text-primary me-2"></i><strong>NIK:</strong> <span id="modalNik"></span></div></div>
                    <div class="col-6"><div class="info-box"><i class="fas fa-venus-mars text-warning me-2"></i><strong>Jenis Kelamin:</strong> <span id="modalJenisKelamin"></span></div></div>
                    <div class="col-6"><div class="info-box"><i class="fas fa-calendar text-info me-2"></i><strong>Tempat/Tgl Lahir:</strong> <span id="modalTempatLahir"></span></div></div>
                    <div class="col-12"><div class="info-box"><i class="fas fa-envelope text-primary me-2"></i><strong>Email:</strong> <span id="modalEmail"></span></div></div>
                    <div class="col-6"><div class="info-box"><i class="fas fa-phone text-success me-2"></i><strong>No HP:</strong> <span id="modalPhone"></span></div></div>
                    <div class="col-6"><div class="info-box"><i class="fas fa-map-marker-alt text-danger me-2"></i><strong>RT/RW:</strong> <span id="modalRtRw"></span></div></div>
                    <div class="col-12"><div class="info-box"><i class="fas fa-home text-warning me-2"></i><strong>Alamat:</strong> <span id="modalAddress"></span></div></div>
                    <div class="col-12"><div class="info-box"><i class="fas fa-briefcase text-secondary me-2"></i><strong>Pekerjaan:</strong> <span id="modalPekerjaan"></span></div></div>
                    <div class="col-6"><div class="info-box"><i class="fas fa-church text-purple me-2"></i><strong>Agama:</strong> <span id="modalAgama"></span></div></div>
                    <div class="col-6"><div class="info-box"><i class="fas fa-heart text-danger me-2"></i><strong>Status:</strong> <span id="modalStatus"></span></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Tutup</button>
                <button type="button" class="btn btn-primary" id="editFromModalBtn"><i class="fas fa-edit me-2"></i>Edit Profil</button>
            </div>
        </div>
    </div>
</div>

<script>
    function createPageBubble() {
        const bubble = document.createElement('div'); bubble.classList.add('page-bubble');
        const size = Math.random() * 30 + 5;
        bubble.style.width = size + 'px'; bubble.style.height = size + 'px';
        bubble.style.left = Math.random() * 100 + '%';
        bubble.style.animationDuration = Math.random() * 8 + 6 + 's';
        document.body.appendChild(bubble);
        setTimeout(() => bubble.remove(), 12000);
    }
    setInterval(createPageBubble, 500);

    function viewWarga(warga) {
        const avatarUrl = warga.avatar ? '{{ asset("storage/avatars/") }}/' + warga.avatar : 'https://ui-avatars.com/api/?background=0a4d6e&color=fff&name=' + encodeURIComponent(warga.name);
        document.getElementById('modalAvatar').src = avatarUrl;
        document.getElementById('modalName').innerHTML = warga.name;
        document.getElementById('modalNik').innerHTML = warga.nik || '-';
        document.getElementById('modalJenisKelamin').innerHTML = warga.jenis_kelamin == 'L' ? 'Laki-laki' : (warga.jenis_kelamin == 'P' ? 'Perempuan' : '-');
        document.getElementById('modalTempatLahir').innerHTML = (warga.tempat_lahir ? warga.tempat_lahir + ', ' : '') + (warga.tanggal_lahir ? warga.tanggal_lahir : '-');
        document.getElementById('modalEmail').innerHTML = warga.email || '-';
        document.getElementById('modalPhone').innerHTML = warga.phone || '-';
        document.getElementById('modalRtRw').innerHTML = (warga.rt ? 'RT ' + warga.rt : 'RT -') + '/' + (warga.rw ? 'RW ' + warga.rw : 'RW -');
        document.getElementById('modalAddress').innerHTML = warga.address || '-';
        document.getElementById('modalPekerjaan').innerHTML = warga.pekerjaan || '-';
        document.getElementById('modalAgama').innerHTML = warga.agama || '-';
        document.getElementById('modalStatus').innerHTML = warga.status_perkawinan || '-';
        document.getElementById('editFromModalBtn').onclick = function() { window.location.href = '/warga/' + warga.id + '/edit'; };
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data warga akan dihapus beserta semua riwayat iurannya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
        });
    }
</script>
@endsection