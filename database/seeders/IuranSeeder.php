<?php
namespace Database\Seeders;
use App\Models\Iuran;
use App\Models\User;
use Illuminate\Database\Seeder;

class IuranSeeder extends Seeder {
    public function run(): void {
        $wargas = User::where('role_id', 3)->get();
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($wargas as $warga) {
            for ($i=0; $i<6; $i++) {
                Iuran::create([
                    'user_id' => $warga->id,
                    'bulan' => $months[$i],
                    'tahun' => date('Y'),
                    'jumlah' => 50000,
                    'tanggal_bayar' => now()->subMonths(6-$i),
                    'status' => $i < 3 ? 'lunas' : 'belum',
                    'jenis' => 'iuran_wajib',
                    'keterangan' => 'Iuran bulan ' . $months[$i]
                ]);
            }
        }
    }
}
