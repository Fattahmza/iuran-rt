<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KategoriTransaksi extends Model {
    protected $fillable = ['name', 'type', 'icon', 'color'];
    public function iurans() { return $this->hasMany(Iuran::class, 'kategori_id'); }
}
