<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\KategoriTransaksi;
use App\Models\JenisIuran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // ========== UNTUK ADMIN & BENDAHARA ==========
        if ($user->isAdmin() || $user->isBendahara()) {

            // Statistik Utama
            $totalPemasukan = Iuran::where('status', 'lunas')->where('tipe', 'pemasukan')->sum('jumlah');
            $totalPengeluaran = Iuran::where('status', 'lunas')->where('tipe', 'pengeluaran')->sum('jumlah');
            $saldoKas = $totalPemasukan - $totalPengeluaran;
            $totalWarga = User::whereHas('role', function($q) {
                $q->where('name', 'warga');
            })->count();

            $persenPemasukan = 12.5;
            $persenPengeluaran = 8.3;

            // Grafik Kas Bulanan
            $monthlyData = [];
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'];
            foreach ($months as $index => $month) {
                $monthNum = $index + 1;
                $pemasukan = Iuran::where('tipe', 'pemasukan')->where('status', 'lunas')
                    ->whereMonth('tanggal_bayar', $monthNum)->whereYear('tanggal_bayar', date('Y'))
                    ->sum('jumlah');
                $pengeluaran = Iuran::where('tipe', 'pengeluaran')->where('status', 'lunas')
                    ->whereMonth('tanggal_bayar', $monthNum)->whereYear('tanggal_bayar', date('Y'))
                    ->sum('jumlah');
                $monthlyData[] = [
                    'bulan' => $month,
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                ];
            }

            // Pengeluaran per Kategori
            $pengeluaranPerKategori = KategoriTransaksi::where('type', 'pengeluaran')
                ->withSum(['iurans as total' => function($q) {
                    $q->where('status', 'lunas');
                }], 'jumlah')
                ->get()
                ->filter(function($k) {
                    return ($k->total ?? 0) > 0;
                })
                ->take(5);

            // Transaksi Terbaru
            $transaksiTerbaru = Iuran::with(['user', 'kategori', 'jenisIuran'])
                ->where('status', 'lunas')
                ->latest()
                ->take(5)
                ->get();

            // Pengumuman
            $pengumumanTerbaru = Pengumuman::with('creator')
                ->where('is_active', true)
                ->latest()
                ->take(3)
                ->get();

            // Iuran Telat
            $iuranTelat = Iuran::where('status', '!=', 'lunas')
                ->where('tipe', 'pemasukan')
                ->with(['user', 'jenisIuran'])
                ->get()
                ->filter(function($item) {
                    return $item->isTerlambat();
                });

            $totalTelat = $iuranTelat->count();
            $totalDenda = $iuranTelat->sum('denda');

            // Statistik Chart
            $statistik_bulanan = Iuran::select(DB::raw('MONTH(tanggal_bayar) as bulan'), DB::raw('SUM(jumlah) as total'))
                ->where('status', 'lunas')->where('tipe', 'pemasukan')
                ->whereYear('tanggal_bayar', date('Y'))
                ->groupBy(DB::raw('MONTH(tanggal_bayar)'))
                ->get();

            $iuran_per_jenis = Iuran::select('jenis', DB::raw('SUM(jumlah) as total'))
                ->where('status', 'lunas')
                ->groupBy('jenis')
                ->get();

            $data = compact(
                'totalPemasukan', 'totalPengeluaran', 'saldoKas', 'totalWarga',
                'persenPemasukan', 'persenPengeluaran', 'monthlyData',
                'pengeluaranPerKategori', 'transaksiTerbaru', 'pengumumanTerbaru',
                'statistik_bulanan', 'iuran_per_jenis', 'iuranTelat', 'totalTelat', 'totalDenda'
            );

            $data['total_warga'] = $totalWarga;
            $data['total_iuran'] = Iuran::count();
            $data['total_pemasukan'] = $totalPemasukan;
            $data['total_belum_bayar'] = Iuran::where('status', 'belum')->count();
            $data['iuran_terbaru'] = Iuran::with('user')->latest()->take(5)->get();
            $data['top_pembayar'] = Iuran::select('user_id', DB::raw('SUM(jumlah) as total'), DB::raw('COUNT(*) as count'))
                ->where('status', 'lunas')
                ->groupBy('user_id')
                ->with('user')
                ->orderBy('total', 'desc')
                ->take(5)
                ->get();

            return view('dashboard', $data);
        }

        // ========== UNTUK WARGA ==========
        else {
            // Riwayat Pembayaran Iuran (yang sudah lunas)
            $riwayatPembayaran = Iuran::where('user_id', $user->id)
                ->where('status', 'lunas')
                ->where('tipe', 'pemasukan')
                ->with('jenisIuran')
                ->latest()
                ->paginate(10);

            // Iuran yang Belum Lunas
            $tagihanBelumLunas = Iuran::where('user_id', $user->id)
                ->where('status', 'belum')
                ->where('tipe', 'pemasukan')
                ->with('jenisIuran')
                ->get();

            // Total yang sudah dibayar
            $totalSudahBayar = Iuran::where('user_id', $user->id)
                ->where('status', 'lunas')
                ->where('tipe', 'pemasukan')
                ->sum('jumlah');

            // Total yang belum dibayar
            $totalBelumBayar = Iuran::where('user_id', $user->id)
                ->where('status', 'belum')
                ->where('tipe', 'pemasukan')
                ->sum('jumlah');

            // Total denda jika ada yang telat
            $iuranTelat = Iuran::where('user_id', $user->id)
                ->where('status', '!=', 'lunas')
                ->where('tipe', 'pemasukan')
                ->with('jenisIuran')
                ->get()
                ->filter(function($item) {
                    return $item->isTerlambat();
                });

            $totalDenda = $iuranTelat->sum('denda');

            return view('dashboard-warga', compact(
                'riwayatPembayaran',
                'tagihanBelumLunas',
                'totalSudahBayar',
                'totalBelumBayar',
                'totalDenda',
                'iuranTelat'
            ));
        }
    }
}
