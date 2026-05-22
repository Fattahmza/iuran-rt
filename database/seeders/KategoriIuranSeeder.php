<?php
namespace Database\Seeders;
use App\Models\KategoriIuran;
use Illuminate\Database\Seeder;

class KategoriIuranSeeder extends Seeder {
    public function run(): void {
        KategoriIuran::create(['nama'=>'Iuran Bulanan', 'nominal'=>50000, 'deskripsi'=>'Iuran rutin setiap bulan']);
        KategoriIuran::create(['nama'=>'Iuran Pembangunan', 'nominal'=>100000, 'deskripsi'=>'Iuran untuk pembangunan desa']);
        KategoriIuran::create(['nama'=>'Iuran Kebersihan', 'nominal'=>20000, 'deskripsi'=>'Iuran kebersihan lingkungan']);
        KategoriIuran::create(['nama'=>'Denda Keterlambatan', 'nominal'=>10000, 'deskripsi'=>'Denda telat bayar iuran']);
    }
}
