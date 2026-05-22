<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use Illuminate\Http\Request;

class LaporanKasController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-t');

        $pemasukan = Iuran::where('tipe', 'pemasukan')
            ->where('status', 'lunas')
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->get();

        $pengeluaran = Iuran::where('tipe', 'pengeluaran')
            ->where('status', 'lunas')
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->get();

        $totalPemasukan = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('laporan-kas.index', compact('pemasukan', 'pengeluaran', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir', 'startDate', 'endDate'));
    }
}
