<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\KategoriTransaksi;
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

        // ========== STATISTIK UTAMA ==========
        $totalPemasukan = Iuran::where('status', 'lunas')->where('tipe', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Iuran::where('status', 'lunas')->where('tipe', 'pengeluaran')->sum('jumlah');
        $saldoKas = $totalPemasukan - $totalPengeluaran;
        $totalWarga = User::whereHas('role', function($q) {
            $q->where('name', 'warga');
        })->count();

        // Persentase perubahan (dummy untuk demo)
        $persenPemasukan = 12.5;
        $persenPengeluaran = 8.3;

        // ========== GRAFIK KAS BULANAN (7 bulan terakhir) ==========
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

        // ========== PENGELUARAN PER KATEGORI ==========
        $pengeluaranPerKategori = KategoriTransaksi::where('type', 'pengeluaran')
            ->withSum(['iurans as total' => function($q) {
                $q->where('status', 'lunas');
            }], 'jumlah')
            ->get()
            ->filter(function($k) {
                return ($k->total ?? 0) > 0;
            })
            ->take(5);

        // ========== TRANSAKSI TERBARU ==========
        $transaksiTerbaru = Iuran::with(['user', 'kategori'])
            ->where('status', 'lunas')
            ->latest()
            ->take(5)
            ->get();

        // ========== PENGUMUMAN TERBARU ==========
        $pengumumanTerbaru = Pengumuman::with('creator')
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        // ========== DATA UNTUK VIEW YANG SUDAH ADA ==========
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
            'statistik_bulanan', 'iuran_per_jenis'
        );

        // Data untuk admin/bendahara
        if ($user->isAdmin() || $user->isBendahara()) {
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
        } else {
            $data['total_iuran_saya'] = Iuran::where('user_id', $user->id)->count();
            $data['total_bayar_saya'] = Iuran::where('user_id', $user->id)
                ->where('status', 'lunas')
                ->sum('jumlah');
            $data['iuran_terbaru'] = Iuran::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', $data);
    }
}
