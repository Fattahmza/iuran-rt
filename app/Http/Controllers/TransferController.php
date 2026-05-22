<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\User;
use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function index()
    {
        $transfers = Iuran::where('tipe', 'transfer')
            ->with('user')
            ->latest()
            ->paginate(15);

        $wargas = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->get();
        $kategoris = KategoriTransaksi::where('type', 'pengeluaran')->get();

        return view('transfer.index', compact('transfers', 'wargas', 'kategoris'));
    }

    public function create()
    {
        $wargas = User::whereHas('role', fn($q) => $q->where('name', 'warga'))->get();
        $kategoris = KategoriTransaksi::where('type', 'pengeluaran')->get();

        return view('transfer.create', compact('wargas', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_bayar' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        Iuran::create([
            'user_id' => $request->user_id,
            'bulan' => date('F'),
            'tahun' => date('Y'),
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
            'status' => 'lunas',
            'jenis' => 'transfer',
            'tipe' => 'transfer',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transfer.index')->with('success', 'Transfer berhasil ditambahkan');
    }

    public function destroy(Iuran $transfer)
    {
        $transfer->delete();
        return redirect()->route('transfer.index')->with('success', 'Transfer berhasil dihapus');
    }
}
