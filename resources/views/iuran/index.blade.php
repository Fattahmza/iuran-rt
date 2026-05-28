@extends('layouts.app')

@section('header', 'Data Iuran')
@section('subheader', 'Kelola data iuran warga')

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
        opacity: 0.6;
    }
    .page-big-fish .strip { position: absolute; width: 7px; height: 40px; background: white; top: -2px; border-radius: 4px; }
    .page-big-fish .strip1 { left: 12px; transform: rotate(-5deg); }
    .page-big-fish .strip2 { left: 30px; }
    .page-big-fish .strip3 { left: 48px; transform: rotate(5deg); }
    .page-big-fish .eye { position: absolute; width: 8px; height: 8px; background: white; border-radius: 50%; top: 8px; right: 12px; }
    .page-big-fish .eye::after { content: ''; position: absolute; width: 4px; height: 4px; background: black; border-radius: 50%; top: 2px; right: 2px; }
    .page-big-fish .tail { position: absolute; width: 0; height: 0; border-left: 18px solid #ee5a24; border-top: 12px solid transparent; border-bottom: 12px solid transparent; left: -15px; top: 5px; animation: pageTailWiggle 0.6s infinite alternate; }
    .page-big-fish .fin { position: absolute; width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-bottom: 14px solid #ee5a24; top: -10px; left: 25px; }
    @keyframes pageTailWiggle { from { transform: rotate(-10deg); } to { transform: rotate(10deg); } }

    .page-small-fish {
        position: fixed; width: 30px; height: 15px; background: linear-gradient(135deg, #feca57, #ff9f43);
        border-radius: 50%; animation: pageSwimFree 20s infinite linear; z-index: 5; pointer-events: none; opacity: 0.5;
    }
    .page-small-fish .eye { position: absolute; width: 4px; height: 4px; background: white; border-radius: 50%; top: 3px; right: 6px; }
    .page-small-fish .tail { position: absolute; width: 0; height: 0; border-left: 7px solid #ff9f43; border-top: 5px solid transparent; border-bottom: 5px solid transparent; left: -7px; top: 2px; animation: pageTailWiggle 0.3s infinite alternate; }

    .page-green-fish {
        position: fixed; width: 25px; height: 12px; background: linear-gradient(135deg, #1dd1a1, #10ac84);
        border-radius: 50%; animation: pageSwimFree 18s infinite linear; z-index: 5; pointer-events: none; opacity: 0.5;
    }
    .page-green-fish .eye { position: absolute; width: 3px; height: 3px; background: white; border-radius: 50%; top: 3px; right: 5px; }
    .page-green-fish .tail { position: absolute; width: 0; height: 0; border-left: 6px solid #10ac84; border-top: 4px solid transparent; border-bottom: 4px solid transparent; left: -6px; top: 2px; animation: pageTailWiggle 0.4s infinite alternate; }

    @keyframes pageSwimFree {
        0% { transform: translateX(-200px) translateY(0) scaleX(1); }
        49% { transform: translateX(calc(100vw + 200px)) translateY(0) scaleX(1); }
        50% { transform: translateX(calc(100vw + 200px)) translateY(0) scaleX(-1); }
        99% { transform: translateX(-200px) translateY(0) scaleX(-1); }
        100% { transform: translateX(-200px) translateY(0) scaleX(1); }
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

    /* Badge Telat */
    .badge-telat { background: #dc3545; color: white; padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.7rem; }
</style>

<!-- Ikan di Tengah -->
<div class="page-center-fish">
    <div class="page-big-fish">
        <div class="strip strip1"></div><div class="strip strip2"></div><div class="strip strip3"></div>
        <div class="eye"></div><div class="tail"></div><div class="fin"></div>
    </div>
</div>

<!-- Ikan Kecil -->
<div class="page-small-fish" style="top: 10%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 25%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-green-fish" style="top: 45%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-small-fish" style="top: 70%; left: 0;"><div class="eye"></div><div class="tail"></div></div>
<div class="page-green-fish" style="top: 88%; left: 0;"><div class="eye"></div><div class="tail"></div></div>

<div class="card fade-in-up" style="position: relative; z-index: 10;">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="fw-bold mb-0"><i class="fas fa-database me-2 text-primary"></i>Data Iuran Warga</h5>
        @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
        <a href="{{ route('iuran.create') }}" class="btn btn-gradient btn-sm"><i class="fas fa-plus-circle me-2"></i>Tambah Iuran</a>
        @endif
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('iuran.index') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="input-group"><span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Cari nama warga..." value="{{ request('search') }}"></div>
            </div>
            <div class="col-md-2">
                <select name="bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    @foreach($bulanList ?? [] as $bulan)
                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList ?? [] as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i>Filter</button>
                <a href="{{ route('iuran.index') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-2"></i>Reset</a>
            </div>
        </form>

        <!-- ========== TAMBAHKAN FILTER JENIS IURAN ========== -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="btn-group flex-wrap" role="group">
                    <a href="{{ route('iuran.index') }}" class="btn btn-outline-primary btn-sm {{ !request('jenis') ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('iuran.index', ['jenis' => 'iuran_bulanan']) }}" class="btn btn-outline-primary btn-sm {{ request('jenis') == 'iuran_bulanan' ? 'active' : '' }}">Iuran Bulanan</a>
                    <a href="{{ route('iuran.index', ['jenis' => 'keamanan']) }}" class="btn btn-outline-primary btn-sm {{ request('jenis') == 'keamanan' ? 'active' : '' }}">Iuran Keamanan</a>
                    <a href="{{ route('iuran.index', ['jenis' => 'kebersihan']) }}" class="btn btn-outline-primary btn-sm {{ request('jenis') == 'kebersihan' ? 'active' : '' }}">Iuran Kebersihan</a>
                    <a href="{{ route('iuran.index', ['jenis' => 'perawatan']) }}" class="btn btn-outline-primary btn-sm {{ request('jenis') == 'perawatan' ? 'active' : '' }}">Iuran Perawatan</a>
                    <a href="{{ route('iuran.index', ['jenis' => 'kegiatan_rutin']) }}" class="btn btn-outline-primary btn-sm {{ request('jenis') == 'kegiatan_rutin' ? 'active' : '' }}">Kegiatan Rutin</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Warga</th>
                        <th>RT/RW</th>
                        <th>Jenis Iuran</th>
                        <th>Bulan/Tahun</th>
                        <th>Jumlah</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                        @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())<th>Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($iurans ?? [] as $i => $item)
                    @php $warga = $item->user; @endphp
                    <tr>
                        <td class="fw-bold">{{ $iurans->firstItem() + $i }}</td>
                        <td><img src="{{ $warga && $warga->avatar ? asset('storage/avatars/'.$warga->avatar) : 'https://ui-avatars.com/api/?background=0a4d6e&color=fff&name='.urlencode($warga->name ?? 'U') }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;"></td>
                        <td><div><strong>{{ $warga->name ?? 'Unknown' }}</strong><br><small class="text-muted">{{ $warga->email ?? '-' }}</small></div></td>
                        <td>RT {{ $warga->rt ?? '-' }}/RW {{ $warga->rw ?? '-' }}</td>
                        <td><span class="badge bg-{{ $item->jenisColor }}"><i class="{{ $item->jenisIcon }} me-1"></i>{{ $item->jenisLabel }}</span></td>
                        <td>{{ $item->bulan ?? '-' }} {{ $item->tahun ?? '-' }}</td>
                        <td class="fw-bold">Rp {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                        <td>{!! $item->statusBadge !!}</td>
                        @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                        <td><div class="btn-group"><a href="{{ route('iuran.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>@if(auth()->user()->isAdmin())<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})" title="Hapus"><i class="fas fa-trash"></i></button><form id="delete-form-{{ $item->id }}" action="{{ route('iuran.destroy', $item->id) }}" method="POST" style="display: none;">@csrf @method('DELETE')</form>@endif</div></td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>Belum ada data iuran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $iurans->withQueryString()->links() }}</div>
    </div>
</div>

<script>
    function createPageBubble() {
        const bubble = document.createElement('div');
        bubble.classList.add('page-bubble');
        const size = Math.random() * 30 + 5;
        bubble.style.width = size + 'px';
        bubble.style.height = size + 'px';
        bubble.style.left = Math.random() * 100 + '%';
        bubble.style.animationDuration = Math.random() * 8 + 6 + 's';
        document.body.appendChild(bubble);
        setTimeout(() => bubble.remove(), 12000);
    }
    setInterval(createPageBubble, 500);

    function confirmDelete(id) {
        Swal.fire({ title: 'Apakah Anda yakin?', text: "Data iuran akan dihapus secara permanen!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); } });
    }
</script>
@endsection
