@extends('layouts.app')

@section('header', 'Bayar Iuran')
@section('subheader', 'Lakukan pembayaran iuran Anda')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-credit-card me-2 text-primary"></i>Form Pembayaran Iuran
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('iuran.store') }}" method="POST" id="formIuran" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Warga -->
                    <div class="mb-3" id="userSelectContainer">
                        <label class="form-label fw-bold">Nama Warga <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Pilih Warga</option>
                            @foreach($wargas ?? [] as $warga)
                            <option value="{{ $warga->id }}" {{ old('user_id', request('user_id', $selectedUserId)) == $warga->id ? 'selected' : '' }}>
                                {{ $warga->name }} - RT {{ $warga->rt ?? '-' }}/RW {{ $warga->rw ?? '-' }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Bulan <span class="text-danger">*</span></label>
                            <select name="bulan" class="form-select @error('bulan') is-invalid @enderror" required>
                                <option value="">Pilih Bulan</option>
                                <option value="Januari" {{ old('bulan', request('bulan')) == 'Januari' ? 'selected' : '' }}>Januari</option>
                                <option value="Februari" {{ old('bulan', request('bulan')) == 'Februari' ? 'selected' : '' }}>Februari</option>
                                <option value="Maret" {{ old('bulan', request('bulan')) == 'Maret' ? 'selected' : '' }}>Maret</option>
                                <option value="April" {{ old('bulan', request('bulan')) == 'April' ? 'selected' : '' }}>April</option>
                                <option value="Mei" {{ old('bulan', request('bulan')) == 'Mei' ? 'selected' : '' }}>Mei</option>
                                <option value="Juni" {{ old('bulan', request('bulan')) == 'Juni' ? 'selected' : '' }}>Juni</option>
                                <option value="Juli" {{ old('bulan', request('bulan')) == 'Juli' ? 'selected' : '' }}>Juli</option>
                                <option value="Agustus" {{ old('bulan', request('bulan')) == 'Agustus' ? 'selected' : '' }}>Agustus</option>
                                <option value="September" {{ old('bulan', request('bulan')) == 'September' ? 'selected' : '' }}>September</option>
                                <option value="Oktober" {{ old('bulan', request('bulan')) == 'Oktober' ? 'selected' : '' }}>Oktober</option>
                                <option value="November" {{ old('bulan', request('bulan')) == 'November' ? 'selected' : '' }}>November</option>
                                <option value="Desember" {{ old('bulan', request('bulan')) == 'Desember' ? 'selected' : '' }}>Desember</option>
                            </select>
                            @error('bulan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                            <select name="tahun" class="form-select @error('tahun') is-invalid @enderror" required>
                                <option value="">Pilih Tahun</option>
                                @for($i = date('Y')-2; $i <= date('Y')+1; $i++)
                                <option value="{{ $i }}" {{ old('tahun', request('tahun')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Iuran <span class="text-danger">*</span></label>
                            <select name="jenis_iuran_id" id="jenis_iuran_id" class="form-select @error('jenis_iuran_id') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Iuran</option>
                                @foreach($jenisIurans ?? [] as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_iuran_id', request('jenis_iuran_id')) == $jenis->id ? 'selected' : '' }} data-nominal="{{ $jenis->nominal_default }}">
                                    <i class="{{ $jenis->icon }}"></i> {{ $jenis->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_iuran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jumlah (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                   placeholder="Contoh: 50000" value="{{ old('jumlah', request('jumlah')) }}" required>
                            @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required>
                                <option value="">Pilih Metode</option>
                                <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>💵 Cash (Tunai)</option>
                                <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>🏦 Transfer Bank</option>
                                <option value="qris" {{ old('metode_pembayaran') == 'qris' ? 'selected' : '' }}>📱 QRIS</option>
                                <option value="other" {{ old('metode_pembayaran') == 'other' ? 'selected' : '' }}>📝 Lainnya</option>
                            </select>
                            @error('metode_pembayaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Bayar <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_bayar" class="form-control @error('tanggal_bayar') is-invalid @enderror"
                                   value="{{ old('tanggal_bayar', request('tanggal_bayar', date('Y-m-d'))) }}" required>
                            @error('tanggal_bayar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept="image/*,.pdf" required>
                        <small class="text-muted">Upload bukti transfer/foto struk (JPG, PNG, PDF max 2MB)</small>
                        @error('bukti_pembayaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="previewBukti" class="mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                  rows="2" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>Setelah melakukan pembayaran, bukti akan diverifikasi oleh Admin/Bendahara. Status akan berubah menjadi "Lunas" setelah diverifikasi.</span>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('iuran.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success" id="btnSubmit">
                            <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const jenisSelect = document.getElementById('jenis_iuran_id');
    const jumlahInput = document.getElementById('jumlah');
    const buktiInput = document.getElementById('bukti_pembayaran');
    const previewBukti = document.getElementById('previewBukti');
    const submitBtn = document.getElementById('btnSubmit');

    // Preview bukti pembayaran
    if (buktiInput) {
        buktiInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewBukti.innerHTML = `<img src="${event.target.result}" class="img-thumbnail mt-2" style="max-height: 150px;">`;
                }
                reader.readAsDataURL(file);
            } else if (file) {
                previewBukti.innerHTML = `<div class="alert alert-info mt-2">📄 File: ${file.name}</div>`;
            } else {
                previewBukti.innerHTML = '';
            }
        });
    }

    // Auto fill nominal
    if (jenisSelect && jumlahInput) {
        jenisSelect.addEventListener('change', function() {
            const selectedOption = jenisSelect.options[jenisSelect.selectedIndex];
            const nominalDefault = selectedOption.getAttribute('data-nominal');
            if (nominalDefault && nominalDefault > 0) {
                jumlahInput.value = nominalDefault;
            }
        });
    }

    // Form submit - HANYA VALIDASI SEDERHANA
    const form = document.getElementById('formIuran');

    if (form) {
        form.addEventListener('submit', function(e) {
            const jenisValue = jenisSelect ? jenisSelect.value : '';
            const metodeValue = document.getElementById('metode_pembayaran') ? document.getElementById('metode_pembayaran').value : '';
            const buktiFile = buktiInput ? buktiInput.files[0] : null;

            if (!jenisValue) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Jenis Iuran!',
                    text: 'Silakan pilih jenis iuran yang akan dibayar.',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            if (!metodeValue) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Metode Pembayaran!',
                    text: 'Silakan pilih metode pembayaran.',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            if (!buktiFile) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Bukti Pembayaran Wajib!',
                    text: 'Silakan upload bukti pembayaran.',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            // Tampilkan loading
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
            }

            return true;
        });
    }

    // ========== KHUSUS UNTUK WARGA ==========
    @if(!auth()->user()->isAdmin() && !auth()->user()->isBendahara())
        document.addEventListener('DOMContentLoaded', function() {
            let userSelect = document.getElementById('user_id');
            if (userSelect) {
                userSelect.style.display = 'none';
                let hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'user_id';
                hiddenInput.value = '{{ auth()->user()->id }}';
                userSelect.parentNode.appendChild(hiddenInput);
                let wargaName = document.createElement('div');
                wargaName.className = 'alert alert-info mt-2';
                wargaName.innerHTML = '<i class="fas fa-user me-2"></i> Membayar iuran untuk: <strong>{{ auth()->user()->name }}</strong>';
                userSelect.parentNode.insertBefore(wargaName, userSelect.nextSibling);
            }
        });
    @endif
</script>
@endpush
@endsection
