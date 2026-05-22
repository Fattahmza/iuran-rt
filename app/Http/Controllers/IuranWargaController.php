<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\User;
use Illuminate\Http\Request;

class IuranWargaController extends Controller
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

        $iurans = $query->latest()->paginate(15);

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahunList = range(date('Y')-2, date('Y'));

        return view('iuran-warga.index', compact('iurans', 'bulanList', 'tahunList'));
    }

    public function create()
    {
        $wargas = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->get();
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('iuran-warga.create', compact('wargas', 'bulanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric|min:10000',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,belum,pending',
        ]);

        Iuran::create([
            'user_id' => $request->user_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
            'status' => $request->status,
            'jenis' => 'iuran_wajib',
            'tipe' => 'pemasukan',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('iuran-warga.index')->with('success', 'Iuran warga berhasil ditambahkan');
    }

    public function edit(Iuran $iuranWarga)
    {
        $wargas = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->get();
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('iuran-warga.edit', compact('iuranWarga', 'wargas', 'bulanList'));
    }

    public function update(Request $request, Iuran $iuranWarga)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bulan' => 'required|string',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric|min:10000',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,belum,pending',
        ]);

        $iuranWarga->update($request->all());
        return redirect()->route('iuran-warga.index')->with('success', 'Iuran warga berhasil diupdate');
    }

    public function destroy(Iuran $iuranWarga)
    {
        $iuranWarga->delete();
        return redirect()->route('iuran-warga.index')->with('success', 'Iuran warga berhasil dihapus');
    }
}
