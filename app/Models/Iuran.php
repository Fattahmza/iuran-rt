<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model {
    protected $table = 'iurans';
    protected $fillable = [
        'user_id', 'bulan', 'tahun', 'jumlah', 'tanggal_bayar',
        'status', 'jenis', 'tipe', 'kategori_id', 'keterangan'
    ];
    protected $casts = ['tanggal_bayar' => 'date', 'jumlah' => 'decimal:2'];

    public function user() { return $this->belongsTo(User::class); }
    public function kategori() { return $this->belongsTo(KategoriTransaksi::class, 'kategori_id'); }

    public function getStatusBadgeAttribute() {
        return match($this->status) {
            'lunas' => '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Lunas</span>',
            'belum' => '<span class="badge bg-danger"><i class="fas fa-clock me-1"></i>Belum</span>',
            'pending' => '<span class="badge bg-warning"><i class="fas fa-spinner me-1"></i>Pending</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }
}
