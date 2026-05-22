<?php
namespace Database\Seeders;
use App\Models\KategoriTransaksi;
use Illuminate\Database\Seeder;

class KategoriTransaksiSeeder extends Seeder {
    public function run() {
        $kategoris = [
            ['name' => 'Iuran Wajib', 'type' => 'pemasukan', 'icon' => 'fas fa-money-bill', 'color' => 'success'],
            ['name' => 'Iuran Sukarela', 'type' => 'pemasukan', 'icon' => 'fas fa-hand-holding-heart', 'color' => 'info'],
            ['name' => 'Donasi', 'type' => 'pemasukan', 'icon' => 'fas fa-gift', 'color' => 'primary'],
            ['name' => 'Denda', 'type' => 'pemasukan', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'warning'],
            ['name' => 'Kegiatan Rutin', 'type' => 'pengeluaran', 'icon' => 'fas fa-calendar-alt', 'color' => 'danger'],
            ['name' => 'Kebersihan', 'type' => 'pengeluaran', 'icon' => 'fas fa-broom', 'color' => 'info'],
            ['name' => 'Perawatan', 'type' => 'pengeluaran', 'icon' => 'fas fa-tools', 'color' => 'warning'],
            ['name' => 'Keamanan', 'type' => 'pengeluaran', 'icon' => 'fas fa-shield-alt', 'color' => 'primary'],
            ['name' => 'Administrasi', 'type' => 'pengeluaran', 'icon' => 'fas fa-file-alt', 'color' => 'secondary'],
        ];
        foreach ($kategoris as $k) { KategoriTransaksi::create($k); }
    }
}
