<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IuranExport;
use Barryvdh\DomPDF\Facade\Pdf;

class IuranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Iuran::with('user');

        if (!$user->isAdmin() && !$user->isBendahara()) {
            $query->where('user_id', $user->id);
        }

        if ($request->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }
        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $iurans = $query->latest()->paginate(15);
        $iurans->appends($request->all());

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahunList = range(date('Y')-2, date('Y'));

        return view('iuran.index', compact('iurans', 'bulanList', 'tahunList'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        $wargas = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->get();
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('iuran.create', compact('wargas', 'bulanList'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,belum,pending',
            'jenis' => 'required|in:iuran_wajib,iuran_sukarela,denda,sumbangan,pengeluaran',
            'keterangan' => 'nullable|string'
        ]);

        if ($request->jenis == 'pengeluaran' && empty($request->keterangan)) {
            return back()->withErrors(['keterangan' => 'Keterangan wajib diisi untuk pengeluaran'])->withInput();
        }

        Iuran::create($request->all());

        $message = $request->jenis == 'pengeluaran' ? 'Pengeluaran berhasil ditambahkan' : 'Data iuran berhasil ditambahkan';
        return redirect()->route('iuran.index')->with('success', $message);
    }

    public function edit(Iuran $iuran)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        $wargas = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->get();
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('iuran.edit', compact('iuran', 'wargas', 'bulanList'));
    }

    public function update(Request $request, Iuran $iuran)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,belum,pending',
            'jenis' => 'required|in:iuran_wajib,iuran_sukarela,denda,sumbangan,pengeluaran',
            'keterangan' => 'nullable|string'
        ]);

        $iuran->update($request->all());

        $message = $request->jenis == 'pengeluaran' ? 'Pengeluaran berhasil diupdate' : 'Data iuran berhasil diupdate';
        return redirect()->route('iuran.index')->with('success', $message);
    }

    public function destroy(Iuran $iuran)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $iuran->delete();
        return redirect()->route('iuran.index')->with('success', 'Data iuran berhasil dihapus');
    }

    public function laporan(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }

        $queryPemasukan = Iuran::where('status', 'lunas')
            ->whereNotIn('jenis', ['pengeluaran']);

        $queryPengeluaran = Iuran::where('status', 'lunas')
            ->where('jenis', 'pengeluaran');

        if ($request->bulan) {
            $queryPemasukan->where('bulan', $request->bulan);
            $queryPengeluaran->where('bulan', $request->bulan);
        }
        if ($request->tahun) {
            $queryPemasukan->where('tahun', $request->tahun);
            $queryPengeluaran->where('tahun', $request->tahun);
        }

        $totalPemasukan = $queryPemasukan->sum('jumlah');
        $totalPengeluaran = $queryPengeluaran->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
        $totalTransaksiPemasukan = $queryPemasukan->count();
        $totalTransaksiPengeluaran = $queryPengeluaran->count();

        $iuranPerBulan = Iuran::selectRaw('bulan, tahun, SUM(jumlah) as total, COUNT(*) as count')
            ->where('status', 'lunas')
            ->whereNotIn('jenis', ['pengeluaran'])
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        $pengeluaranPerBulan = Iuran::selectRaw('bulan, tahun, SUM(jumlah) as total, COUNT(*) as count, keterangan')
            ->where('status', 'lunas')
            ->where('jenis', 'pengeluaran')
            ->groupBy('bulan', 'tahun', 'keterangan')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        $iuranPerJenis = Iuran::select('jenis', DB::raw('SUM(jumlah) as total'), DB::raw('COUNT(*) as count'))
            ->where('status', 'lunas')
            ->whereNotIn('jenis', ['pengeluaran'])
            ->groupBy('jenis')
            ->get();

        $topWarga = Iuran::select('user_id', DB::raw('SUM(jumlah) as total'))
            ->where('status', 'lunas')
            ->whereNotIn('jenis', ['pengeluaran'])
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $pengeluaranTerbaru = Iuran::with('user')
            ->where('jenis', 'pengeluaran')
            ->where('status', 'lunas')
            ->latest()
            ->take(10)
            ->get();

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahunList = range(date('Y')-2, date('Y'));

        return view('iuran.laporan', compact(
            'totalPemasukan', 'totalPengeluaran', 'saldoAkhir',
            'totalTransaksiPemasukan', 'totalTransaksiPengeluaran',
            'iuranPerBulan', 'pengeluaranPerBulan', 'iuranPerJenis',
            'topWarga', 'pengeluaranTerbaru', 'bulanList', 'tahunList'
        ));
    }

    public function exportExcel(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        return Excel::download(new IuranExport($request), 'laporan-iuran-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPDF(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }

        $queryPemasukan = Iuran::where('status', 'lunas')
            ->whereNotIn('jenis', ['pengeluaran']);

        $queryPengeluaran = Iuran::where('status', 'lunas')
            ->where('jenis', 'pengeluaran');

        if ($request->bulan) {
            $queryPemasukan->where('bulan', $request->bulan);
            $queryPengeluaran->where('bulan', $request->bulan);
        }
        if ($request->tahun) {
            $queryPemasukan->where('tahun', $request->tahun);
            $queryPengeluaran->where('tahun', $request->tahun);
        }

        $totalPemasukan = $queryPemasukan->sum('jumlah');
        $totalPengeluaran = $queryPengeluaran->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
        $totalTransaksiPemasukan = $queryPemasukan->count();
        $totalTransaksiPengeluaran = $queryPengeluaran->count();

        $iuranPerBulan = Iuran::selectRaw('bulan, tahun, SUM(jumlah) as total, COUNT(*) as count')
            ->where('status', 'lunas')
            ->whereNotIn('jenis', ['pengeluaran'])
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        $pengeluaranPerBulan = Iuran::selectRaw('bulan, tahun, SUM(jumlah) as total, COUNT(*) as count, keterangan')
            ->where('status', 'lunas')
            ->where('jenis', 'pengeluaran')
            ->groupBy('bulan', 'tahun', 'keterangan')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        $iuranPerJenis = Iuran::select('jenis', DB::raw('SUM(jumlah) as total'), DB::raw('COUNT(*) as count'))
            ->where('status', 'lunas')
            ->whereNotIn('jenis', ['pengeluaran'])
            ->groupBy('jenis')
            ->get();

        $topWarga = Iuran::select('user_id', DB::raw('SUM(jumlah) as total'))
            ->where('status', 'lunas')
            ->whereNotIn('jenis', ['pengeluaran'])
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $pengeluaranTerbaru = Iuran::with('user')
            ->where('jenis', 'pengeluaran')
            ->where('status', 'lunas')
            ->latest()
            ->take(10)
            ->get();

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahunList = range(date('Y')-2, date('Y'));

        $data = compact(
            'totalPemasukan', 'totalPengeluaran', 'saldoAkhir',
            'totalTransaksiPemasukan', 'totalTransaksiPengeluaran',
            'iuranPerBulan', 'pengeluaranPerBulan', 'iuranPerJenis',
            'topWarga', 'pengeluaranTerbaru', 'bulanList', 'tahunList'
        );

        $pdf = Pdf::loadView('iuran.laporan-pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-iuran-' . date('Y-m-d') . '.pdf');
    }
}
