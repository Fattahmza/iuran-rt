    @extends('layouts.app')

    @section('header', 'Data Warga')
    @section('subheader', 'Kelola data warga desa')

    @section('content')
    <div class="card">
        <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-users me-2 text-primary"></i>Data Warga
            </h5>
            <a href="{{ route('warga.create') }}" class="btn btn-gradient">
                <i class="fas fa-plus-circle me-2"></i>Tambah Warga
            </a>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('warga.index') }}" class="row g-3 mb-4">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 rounded-start">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Cari NIK, Nama, Email, No HP, RT/RW..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>RT/RW</th>
                            <th>Total Iuran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wargas ?? [] as $i => $item)
                        <tr>
                            <td>{{ $wargas->firstItem() + $i }}</td>
                            <td>
                                <img src="{{ $item->avatar_thumb }}"
                                    class="rounded-circle"
                                    style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #4361ee;"
                                    alt="{{ $item->name }}">
                            </td>
                            <td>
                                <span class="fw-bold">{{ $item->nik ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <strong>{{ $item->name }}</strong>
                                    <small class="text-muted">{{ $item->role->display_name ?? 'Warga' }}</small>
                                </div>
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone ?? '-' }}</td>
                            <td>RT {{ $item->rt ?? '-' }}/RW {{ $item->rw ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ App\Models\Iuran::where('user_id', $item->id)->count() }} transaksi
                                </span>
                                <br>
                                <small class="text-success">
                                    Rp {{ number_format(App\Models\Iuran::where('user_id', $item->id)->where('status', 'lunas')->sum('jumlah'), 0, ',', '.') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('warga.edit', $item->id) }}" class="btn btn-warning btn-sm btn-action" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-info btn-sm btn-action" title="Lihat Profil" data-bs-toggle="modal" data-bs-target="#viewWargaModal"
                                            onclick="viewWarga({{ json_encode($item) }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
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
                            <td colspan="9" class="text-center py-5 text-muted">
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                    <h5 class="modal-title">
                        <i class="fas fa-user-circle me-2"></i>Detail Profil Warga
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img id="modalAvatar" src="" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #667eea;">
                            <h4 id="modalName" class="mb-1"></h4>
                            <span class="badge bg-primary" id="modalRole">Warga</span>
                            <div class="mt-2">
                                <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i> Bergabung: <span id="modalJoinDate"></span></small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="info-box">
                                        <i class="fas fa-id-card text-primary me-2"></i>
                                        <strong>NIK:</strong> <span id="modalNik"></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-box">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <strong>Email:</strong> <span id="modalEmail"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <i class="fas fa-phone text-success me-2"></i>
                                        <strong>No HP:</strong> <span id="modalPhone"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <strong>RT/RW:</strong> <span id="modalRtRw"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <i class="fas fa-calendar text-info me-2"></i>
                                        <strong>Tempat/Tgl Lahir:</strong> <span id="modalTempatLahir"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <i class="fas fa-venus-mars text-warning me-2"></i>
                                        <strong>Jenis Kelamin:</strong> <span id="modalJenisKelamin"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <i class="fas fa-briefcase text-secondary me-2"></i>
                                        <strong>Pekerjaan:</strong> <span id="modalPekerjaan"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <i class="fas fa-church text-purple me-2"></i>
                                        <strong>Agama:</strong> <span id="modalAgama"></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-box">
                                        <i class="fas fa-home text-warning me-2"></i>
                                        <strong>Alamat:</strong> <span id="modalAddress"></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-box">
                                        <i class="fas fa-comment text-secondary me-2"></i>
                                        <strong>Bio:</strong> <span id="modalBio"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                    <button type="button" class="btn btn-primary" id="editFromModalBtn">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .info-box {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 10px;
            margin-bottom: 5px;
        }
        .text-purple { color: #6f42c1; }
    </style>

    @push('scripts')
    <script>
        function viewWarga(warga) {
            document.getElementById('modalAvatar').src = warga.avatar_url || 'https://ui-avatars.com/api/?background=4361ee&color=fff&name=' + encodeURIComponent(warga.name);
            document.getElementById('modalName').innerHTML = warga.name;
            document.getElementById('modalNik').innerHTML = warga.nik || '-';
            document.getElementById('modalEmail').innerHTML = warga.email || '-';
            document.getElementById('modalPhone').innerHTML = warga.phone || '-';
            document.getElementById('modalRtRw').innerHTML = (warga.rt ? 'RT ' + warga.rt : 'RT -') + '/' + (warga.rw ? 'RW ' + warga.rw : 'RW -');
            document.getElementById('modalTempatLahir').innerHTML = (warga.tempat_lahir ? warga.tempat_lahir + ', ' : '') + (warga.tanggal_lahir ? warga.tanggal_lahir : '-');
            document.getElementById('modalJenisKelamin').innerHTML = warga.jenis_kelamin == 'L' ? 'Laki-laki' : (warga.jenis_kelamin == 'P' ? 'Perempuan' : '-');
            document.getElementById('modalPekerjaan').innerHTML = warga.pekerjaan || '-';
            document.getElementById('modalAgama').innerHTML = warga.agama || '-';
            document.getElementById('modalAddress').innerHTML = warga.address || '-';
            document.getElementById('modalBio').innerHTML = warga.bio || 'Tidak ada bio';
            document.getElementById('modalJoinDate').innerHTML = warga.created_at ? new Date(warga.created_at).toLocaleDateString('id-ID') : '-';

            document.getElementById('editFromModalBtn').onclick = function() {
                window.location.href = '/warga/' + warga.id + '/edit';
            };
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
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    @endpush
    @endsection
