<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\User;
use App\Models\JenisIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IuranExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class IuranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Iuran::with(['user', 'jenisIuran', 'verifikator']);

        if (!$user->isAdmin() && !$user->isBendahara()) {
            $query->where('user_id', $user->id);
        }

        // Filter berdasarkan tipe (pemasukan/pengeluaran)
        if ($request->tipe == 'pengeluaran') {
            $query->where('tipe', 'pengeluaran');
        } else {
            $query->where('tipe', 'pemasukan');
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
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $iurans = $query->latest()->paginate(15);
        $iurans->appends($request->all());

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahunList = range(date('Y')-2, date('Y'));

        return view('iuran.index', compact('iurans', 'bulanList', 'tahunList'));
    }

    public function create()
    {
        if (!Auth::check()) {
            abort(403);
        }

        $wargas = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->get();
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $jenisIurans = JenisIuran::where('is_active', true)->get();

        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isBendahara()) {
            $wargas = collect([$user]);
            $selectedUserId = $user->id;
        } else {
            $selectedUserId = null;
        }

        return view('iuran.create', compact('wargas', 'bulanList', 'jenisIurans', 'selectedUserId'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $user = Auth::user();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_bayar' => 'required|date',
            'jenis_iuran_id' => 'required',
            'metode_pembayaran' => 'required|in:cash,transfer,qris,other',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        if (!$user->isAdmin() && !$user->isBendahara()) {
            if ($request->user_id != $user->id) {
                return back()->withErrors(['user_id' => 'Anda hanya bisa membayar iuran untuk diri sendiri'])->withInput();
            }
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $request->user_id . '.' . $file->getClientOriginalExtension();
            $buktiPath = $file->storeAs('bukti_pembayaran', $filename, 'public');
        }

        $jenisIuran = JenisIuran::find($request->jenis_iuran_id);
        $data = [
            'user_id' => $request->user_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
            'status' => 'pending',
            'verifikasi_status' => 'pending',
            'keterangan' => $request->keterangan,
            'tipe' => 'pemasukan',
            'jenis' => $jenisIuran ? $jenisIuran->slug : null,
            'jenis_iuran_id' => $jenisIuran ? $jenisIuran->id : null,
            'bukti_pembayaran' => $buktiPath,
            'metode_pembayaran' => $request->metode_pembayaran,
        ];

        Iuran::create($data);

        return redirect()->route('iuran.index')->with('success', 'Pembayaran berhasil! Silakan tunggu verifikasi dari Admin/Bendahara.');
    }

    public function edit(Iuran $iuran)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }
        $wargas = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->get();
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $jenisIurans = JenisIuran::where('is_active', true)->get();

        return view('iuran.edit', compact('iuran', 'wargas', 'bulanList', 'jenisIurans'));
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
            'jenis_iuran_id' => 'required',
            'keterangan' => 'nullable|string'
        ]);

        $isPengeluaran = ($request->jenis_iuran_id == 'pengeluaran');

        if ($isPengeluaran && empty($request->keterangan)) {
            return back()->withErrors(['keterangan' => 'Keterangan wajib diisi untuk pengeluaran'])->withInput();
        }

        $data = [
            'user_id' => $request->user_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'tipe' => $isPengeluaran ? 'pengeluaran' : 'pemasukan',
        ];

        if ($isPengeluaran) {
            $data['jenis'] = 'pengeluaran';
            $data['jenis_iuran_id'] = null;
        } else {
            $jenisIuran = JenisIuran::find($request->jenis_iuran_id);
            if ($jenisIuran) {
                $data['jenis'] = $jenisIuran->slug;
                $data['jenis_iuran_id'] = $jenisIuran->id;
            } else {
                return back()->withErrors(['jenis_iuran_id' => 'Jenis iuran tidak valid'])->withInput();
            }
        }

        $iuran->update($data);

        $message = $isPengeluaran ? 'Pengeluaran berhasil diupdate' : 'Data iuran berhasil diupdate';
        return redirect()->route('iuran.index')->with('success', $message);
    }

    public function destroy(Iuran $iuran)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($iuran->bukti_pembayaran && Storage::disk('public')->exists($iuran->bukti_pembayaran)) {
            Storage::disk('public')->delete($iuran->bukti_pembayaran);
        }

        $iuran->delete();
        return redirect()->route('iuran.index')->with('success', 'Data iuran berhasil dihapus');
    }

    // ========== VERIFIKASI PEMBAYARAN ==========

    public function verifikasiIndex()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        $pendingVerifikasi = Iuran::where('verifikasi_status', 'pending')
            ->where('status', 'pending')
            ->where('tipe', 'pemasukan')
            ->with(['user', 'jenisIuran', 'verifikator'])
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('iuran.verifikasi', compact('pendingVerifikasi'));
    }

    public function verifikasi(Request $request, Iuran $iuran)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }

        $request->validate([
            'verifikasi_status' => 'required|in:verified,rejected',
            'catatan_verifikasi' => 'nullable|string'
        ]);

        $iuran->update([
            'verifikasi_status' => $request->verifikasi_status,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'status' => $request->verifikasi_status == 'verified' ? 'lunas' : 'belum'
        ]);

        $message = $request->verifikasi_status == 'verified'
            ? 'Pembayaran berhasil diverifikasi dan sudah lunas.'
            : 'Pembayaran ditolak. Silakan hubungi warga untuk mengupload ulang bukti.';

        return redirect()->route('iuran.verifikasi')->with('success', $message);
    }

    public function getDetailVerifikasi($id)
    {
        $iuran = Iuran::with(['user', 'jenisIuran'])->findOrFail($id);

        $denda = 0;
        $hariTerlambat = 0;
        $isTerlambat = false;

        if ($iuran->status != 'lunas' && $iuran->tanggal_bayar) {
            $batasTanggal = $iuran->jenisIuran ? $iuran->jenisIuran->batas_tanggal : 15;
            $tanggalBayar = Carbon::parse($iuran->tanggal_bayar);
            $tanggalBatas = Carbon::create($iuran->tahun, $this->getBulanNumber($iuran->bulan), $batasTanggal);

            if ($tanggalBayar->gt($tanggalBatas)) {
                $isTerlambat = true;
                $hariTerlambat = $tanggalBayar->diffInDays($tanggalBatas);
                $dendaPerHari = $iuran->jenisIuran ? $iuran->jenisIuran->denda_per_hari : 5000;
                $denda = $hariTerlambat * $dendaPerHari;
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $iuran->id,
                'nama_warga' => $iuran->user->name ?? '-',
                'rt' => $iuran->user->rt ?? '-',
                'rw' => $iuran->user->rw ?? '-',
                'jumlah' => number_format($iuran->jumlah, 0, ',', '.'),
                'denda' => number_format($denda, 0, ',', '.'),
                'total_bayar' => number_format($iuran->jumlah + $denda, 0, ',', '.'),
                'metode_pembayaran' => $iuran->metode_pembayaran,
                'tanggal_bayar' => $iuran->tanggal_bayar ? $iuran->tanggal_bayar->format('d/m/Y') : '-',
                'jenis_iuran' => $iuran->jenisIuran->nama ?? $iuran->jenisLabel,
                'bulan' => $iuran->bulan,
                'tahun' => $iuran->tahun,
                'bukti_url' => $iuran->bukti_pembayaran ? asset('storage/' . $iuran->bukti_pembayaran) : null,
                'is_terlambat' => $isTerlambat,
                'hari_terlambat' => $hariTerlambat
            ]
        ]);
    }

    public function prosesVerifikasi(Request $request, $id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses'], 403);
        }

        $request->validate([
            'verifikasi_status' => 'required|in:verified,rejected',
            'catatan_verifikasi' => 'nullable|string|max:500'
        ]);

        $iuran = Iuran::findOrFail($id);

        if ($iuran->verifikasi_status !== 'pending' || $iuran->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Data ini sudah diproses sebelumnya'], 400);
        }

        $updateData = [
            'verifikasi_status' => $request->verifikasi_status,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ];

        if ($request->verifikasi_status == 'verified') {
            $updateData['status'] = 'lunas';
            $message = '✅ Pembayaran berhasil diverifikasi! Status: LUNAS';
        } else {
            $updateData['status'] = 'belum';
            $message = '❌ Pembayaran ditolak. Silakan hubungi warga untuk upload ulang.';
        }

        $iuran->update($updateData);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'id' => $iuran->id,
                'verifikasi_status' => $iuran->verifikasi_status,
                'status' => $iuran->status
            ]
        ]);
    }

    public function showBukti($id)
    {
        $iuran = Iuran::findOrFail($id);

        if (!$iuran->bukti_pembayaran) {
            abort(404, 'Bukti pembayaran tidak ditemukan');
        }

        $path = storage_path('app/public/' . $iuran->bukti_pembayaran);

        if (!file_exists($path)) {
            abort(404, 'File bukti pembayaran tidak ditemukan');
        }

        return response()->file($path);
    }

    // ========== PENGELUARAN RT ==========

    public function pengeluaranCreate()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return view('pengeluaran.create');
    }

    public function pengeluaranStore(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = time() . '_pengeluaran_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $buktiPath = $file->storeAs('bukti_pengeluaran', $filename, 'public');
        }

        Iuran::create([
            'user_id' => Auth::id(),
            'bulan' => date('F', strtotime($request->tanggal)),
            'tahun' => date('Y', strtotime($request->tanggal)),
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal,
            'status' => 'lunas',
            'verifikasi_status' => 'verified',
            'keterangan' => $request->nama_pengeluaran . ' | ' . $request->kategori . ' | ' . ($request->keterangan ?? ''),
            'tipe' => 'pengeluaran',
            'jenis' => 'pengeluaran',
            'jenis_iuran_id' => null,
            'bukti_pembayaran' => $buktiPath,
            'metode_pembayaran' => 'cash',
            'verified_by' => Auth::id(),
            'verified_at' => now()
        ]);

        return redirect()->route('iuran.index', ['tipe' => 'pengeluaran'])->with('success', '✅ Pengeluaran berhasil dicatat!');
    }

    public function pengeluaranDestroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Hanya admin yang bisa menghapus pengeluaran');
        }

        $pengeluaran = Iuran::where('id', $id)->where('tipe', 'pengeluaran')->firstOrFail();

        if ($pengeluaran->bukti_pembayaran && Storage::disk('public')->exists($pengeluaran->bukti_pembayaran)) {
            Storage::disk('public')->delete($pengeluaran->bukti_pembayaran);
        }

        $pengeluaran->delete();

        return redirect()->route('iuran.index', ['tipe' => 'pengeluaran'])->with('success', '✅ Pengeluaran berhasil dihapus!');
    }

    public function pengeluaranBukti($id)
    {
        $pengeluaran = Iuran::where('id', $id)->where('tipe', 'pengeluaran')->firstOrFail();

        if (!$pengeluaran->bukti_pembayaran) {
            abort(404, 'Bukti tidak ditemukan');
        }

        $path = storage_path('app/public/' . $pengeluaran->bukti_pembayaran);

        if (!file_exists($path)) {
            abort(404, 'File bukti tidak ditemukan');
        }

        return response()->file($path);
    }

    // ========== LAPORAN ==========

    public function laporan(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBendahara()) {
            abort(403);
        }

        $queryPemasukan = Iuran::where('status', 'lunas')
            ->where('tipe', 'pemasukan');

        $queryPengeluaran = Iuran::where('status', 'lunas')
            ->where('tipe', 'pengeluaran');

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
            ->where('tipe', 'pemasukan')
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        $pengeluaranPerBulan = Iuran::selectRaw('bulan, tahun, SUM(jumlah) as total, COUNT(*) as count, keterangan')
            ->where('status', 'lunas')
            ->where('tipe', 'pengeluaran')
            ->groupBy('bulan', 'tahun', 'keterangan')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        $iuranPerJenis = Iuran::select('jenis', DB::raw('SUM(jumlah) as total'), DB::raw('COUNT(*) as count'))
            ->where('status', 'lunas')
            ->where('tipe', 'pemasukan')
            ->groupBy('jenis')
            ->get();

        $topWarga = Iuran::select('user_id', DB::raw('SUM(jumlah) as total'))
            ->where('status', 'lunas')
            ->where('tipe', 'pemasukan')
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $pengeluaranTerbaru = Iuran::with('user')
            ->where('tipe', 'pengeluaran')
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
            ->where('tipe', 'pemasukan');

        $queryPengeluaran = Iuran::where('status', 'lunas')
            ->where('tipe', 'pengeluaran');

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
            ->where('tipe', 'pemasukan')
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        $pengeluaranPerBulan = Iuran::selectRaw('bulan, tahun, SUM(jumlah) as total, COUNT(*) as count, keterangan')
            ->where('status', 'lunas')
            ->where('tipe', 'pengeluaran')
            ->groupBy('bulan', 'tahun', 'keterangan')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        $iuranPerJenis = Iuran::select('jenis', DB::raw('SUM(jumlah) as total'), DB::raw('COUNT(*) as count'))
            ->where('status', 'lunas')
            ->where('tipe', 'pemasukan')
            ->groupBy('jenis')
            ->get();

        $topWarga = Iuran::select('user_id', DB::raw('SUM(jumlah) as total'))
            ->where('status', 'lunas')
            ->where('tipe', 'pemasukan')
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $pengeluaranTerbaru = Iuran::with('user')
            ->where('tipe', 'pengeluaran')
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

    // Helper untuk konversi bulan
    private function getBulanNumber($bulan)
    {
        $bulanMap = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
            'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
            'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        return $bulanMap[$bulan] ?? 1;
    }
}
