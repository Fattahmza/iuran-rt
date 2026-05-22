<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;

class KategoriTransaksiController extends Controller
{
    public function index()
    {
        $kategoris = KategoriTransaksi::all();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        KategoriTransaksi::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(KategoriTransaksi $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriTransaksi $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
        ]);

        $kategori->update($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(KategoriTransaksi $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
