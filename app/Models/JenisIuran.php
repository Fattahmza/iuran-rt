<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisIuran extends Model
{
    protected $table = 'jenis_iurans';

    protected $fillable = [
        'nama', 'slug', 'icon', 'color', 'nominal_default', 'deskripsi', 'is_active',
        'denda_per_hari', 'batas_tanggal'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'nominal_default' => 'decimal:2',
        'denda_per_hari' => 'decimal:2'
    ];

    public function iurans()
    {
        return $this->hasMany(Iuran::class, 'jenis_iuran_id');
    }

    // Hitung denda berdasarkan jumlah hari terlambat
    public function hitungDenda($hariTerlambat)
    {
        if ($hariTerlambat <= 0) {
            return 0;
        }
        return $hariTerlambat * $this->denda_per_hari;
    }
}
