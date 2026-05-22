<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanIuranController extends Controller
{
    public function index(Request $request)
    {
        $query = Iuran::where('tipe', 'pemasukan')
            ->where('jenis', 'iuran_wajib')
            ->with('user');

        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $totalIuran = $query->sum('jumlah');
        $totalLunas = $query->where('status', 'lunas')->sum('jumlah');
        $totalBelum = $query->where('status', 'belum')->sum('jumlah');
        $totalWarga = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->count();

        $iurans = $query->latest()->paginate(20);

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahunList = range(date('Y')-2, date('Y'));

        return view('laporan-iuran.index', compact('iurans', 'totalIuran', 'totalLunas', 'totalBelum', 'totalWarga', 'bulanList', 'tahunList'));
    }
}
