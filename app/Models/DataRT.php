<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DataRT extends Model {
    protected $table = 'data_rt';
    protected $fillable = ['nama_rt', 'kode_rt', 'rw', 'kelurahan', 'kecamatan', 'kota', 'provinsi', 'telepon', 'email', 'visi', 'misi'];
}
