<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Iuran extends Model
{
    protected $table = 'iurans';

    protected $fillable = [
        'user_id', 'bulan', 'tahun', 'jumlah', 'tanggal_bayar',
        'status', 'jenis', 'tipe', 'kategori_id', 'keterangan',
        'jenis_iuran_id', 'denda', 'bukti_pembayaran', 'metode_pembayaran',
        'verifikasi_status', 'verified_by', 'verified_at', 'catatan_verifikasi'
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah' => 'decimal:2',
        'denda' => 'decimal:2',
        'verified_at' => 'datetime'
    ];

    // ========== RELASI ==========
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriTransaksi::class, 'kategori_id');
    }

    public function jenisIuran()
    {
        return $this->belongsTo(JenisIuran::class, 'jenis_iuran_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ========== SCOPE VERIFIKASI ==========
    public function scopePendingVerification($query)
    {
        return $query->where('verifikasi_status', 'pending')
                     ->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('verifikasi_status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('verifikasi_status', 'rejected');
    }

    // ========== CEK TELAT BAYAR ==========
    public function isTerlambat()
    {
        if ($this->status == 'lunas') {
            return false;
        }

        $batasTanggal = $this->jenisIuran ? $this->jenisIuran->batas_tanggal : 15;
        $tanggalSekarang = now()->day;

        if ($tanggalSekarang > $batasTanggal && $this->status != 'lunas') {
            return true;
        }

        return false;
    }

    // ========== HITUNG DENDA ==========
    public function getDendaAttribute()
    {
        if (!$this->isTerlambat()) {
            return 0;
        }

        $batasTanggal = $this->jenisIuran ? $this->jenisIuran->batas_tanggal : 15;
        $tanggalSekarang = now()->day;
        $hariTerlambat = $tanggalSekarang - $batasTanggal;

        $dendaPerHari = $this->jenisIuran ? $this->jenisIuran->denda_per_hari : 5000;

        return $hariTerlambat * $dendaPerHari;
    }

    // ========== HITUNG HARI TERLAMBAT ==========
    public function getHariTerlambatAttribute()
    {
        if (!$this->isTerlambat()) {
            return 0;
        }

        $batasTanggal = $this->jenisIuran ? $this->jenisIuran->batas_tanggal : 15;
        $tanggalSekarang = now()->day;
        return $tanggalSekarang - $batasTanggal;
    }

    // ========== TOTAL BAYAR (DENGAN DENDA) ==========
    public function getTotalBayarAttribute()
    {
        return $this->jumlah + $this->denda;
    }

    // ========== LABEL JENIS IURAN ==========
    public function getJenisLabelAttribute()
    {
        if ($this->jenisIuran) {
            return $this->jenisIuran->nama;
        }

        $jenisList = [
            'iuran_bulanan' => 'Iuran Bulanan',
            'keamanan' => 'Iuran Keamanan',
            'kebersihan' => 'Iuran Kebersihan',
            'perawatan' => 'Iuran Perawatan',
            'kegiatan_rutin' => 'Kegiatan Rutin',
            'iuran_wajib' => 'Iuran Wajib',
            'iuran_sukarela' => 'Iuran Sukarela',
            'denda' => 'Denda',
            'sumbangan' => 'Sumbangan',
            'pengeluaran' => 'Pengeluaran'
        ];

        return $jenisList[$this->jenis] ?? ucfirst(str_replace('_', ' ', $this->jenis));
    }

    // ========== ICON JENIS IURAN ==========
    public function getJenisIconAttribute()
    {
        if ($this->jenisIuran) {
            return $this->jenisIuran->icon;
        }

        $iconList = [
            'iuran_bulanan' => 'fas fa-calendar-alt',
            'keamanan' => 'fas fa-shield-alt',
            'kebersihan' => 'fas fa-broom',
            'perawatan' => 'fas fa-tools',
            'kegiatan_rutin' => 'fas fa-calendar-week',
            'iuran_wajib' => 'fas fa-hand-holding-usd',
            'iuran_sukarela' => 'fas fa-heart',
            'denda' => 'fas fa-exclamation-triangle',
            'sumbangan' => 'fas fa-gift',
            'pengeluaran' => 'fas fa-minus-circle'
        ];

        return $iconList[$this->jenis] ?? 'fas fa-tag';
    }

    // ========== WARNA BADGE ==========
    public function getJenisColorAttribute()
    {
        if ($this->jenisIuran) {
            return $this->jenisIuran->color;
        }

        $colorList = [
            'iuran_bulanan' => 'primary',
            'keamanan' => 'danger',
            'kebersihan' => 'success',
            'perawatan' => 'warning',
            'kegiatan_rutin' => 'info',
            'iuran_wajib' => 'primary',
            'iuran_sukarela' => 'success',
            'denda' => 'danger',
            'sumbangan' => 'info',
            'pengeluaran' => 'secondary'
        ];

        return $colorList[$this->jenis] ?? 'secondary';
    }

    // ========== LABEL METODE PEMBAYARAN ==========
    public function getMetodeLabelAttribute()
    {
        return match ($this->metode_pembayaran) {
            'cash' => '<span class="badge bg-info"><i class="fas fa-money-bill-wave me-1"></i>Cash</span>',
            'transfer' => '<span class="badge bg-primary"><i class="fas fa-university me-1"></i>Transfer</span>',
            'qris' => '<span class="badge bg-success"><i class="fas fa-qrcode me-1"></i>QRIS</span>',
            default => '<span class="badge bg-secondary"><i class="fas fa-other me-1"></i>Lainnya</span>'
        };
    }

    // ========== STATUS BADGE ==========
    public function getStatusBadgeAttribute()
    {
        // Jika pending verifikasi
        if ($this->verifikasi_status == 'pending') {
            return '<span class="badge bg-info"><i class="fas fa-spinner me-1"></i>Menunggu Verifikasi</span>';
        }

        // Jika ditolak
        if ($this->verifikasi_status == 'rejected') {
            return '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>';
        }

        // Jika sudah lunas
        if ($this->status == 'lunas') {
            $dendaText = $this->denda > 0 ? ' (+Denda Rp ' . number_format($this->denda, 0, ',', '.') . ')' : '';
            return '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Lunas' . $dendaText . '</span>';
        }

        // Jika telat bayar
        if ($this->isTerlambat()) {
            return '<span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i>Telat ' . $this->hari_terlambat . ' hari</span>';
        }

        // Jika belum telat
        if ($this->status == 'belum') {
            $batasTanggal = $this->jenisIuran ? $this->jenisIuran->batas_tanggal : 15;
            return '<span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Belum (Batas tgl ' . $batasTanggal . ')</span>';
        }

        return '<span class="badge bg-secondary">' . $this->status . '</span>';
    }

    // ========== VERIFIKASI STATUS BADGE ==========
    public function getVerifikasiStatusBadgeAttribute()
    {
        return match ($this->verifikasi_status) {
            'verified' => '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Terverifikasi</span>',
            'rejected' => '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>',
            default => '<span class="badge bg-warning text-dark"><i class="fas fa-spinner me-1"></i>Menunggu</span>'
        };
    }

    // ========== CEK APAKAH BISA DIVERIFIKASI ==========
    public function dapatDiverifikasi()
    {
        return $this->verifikasi_status === 'pending' && $this->status === 'pending';
    }

    // ========== GET URL BUKTI ==========
    public function getBuktiUrlAttribute()
    {
        if ($this->bukti_pembayaran) {
            return asset('storage/' . $this->bukti_pembayaran);
        }
        return null;
    }
}
