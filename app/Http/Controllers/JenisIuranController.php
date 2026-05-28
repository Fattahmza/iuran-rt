<?php

namespace App\Http\Controllers;

use App\Models\JenisIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenisIuranController extends Controller
{
    public function index()
    {
        $jenisIurans = JenisIuran::all();
        return view('jenis-iuran.index', compact('jenisIurans'));
    }

    public function create()
    {
        return view('jenis-iuran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_iurans,nama',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'nominal_default' => 'nullable|numeric',
            'denda_per_hari' => 'nullable|numeric|min:0',
            'batas_tanggal' => 'nullable|integer|min:1|max:31',
            'deskripsi' => 'nullable|string',
        ]);

        JenisIuran::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'icon' => $request->icon ?? 'fas fa-tag',
            'color' => $request->color ?? 'primary',
            'nominal_default' => $request->nominal_default,
            'denda_per_hari' => $request->denda_per_hari ?? 5000,
            'batas_tanggal' => $request->batas_tanggal ?? 15,
            'deskripsi' => $request->deskripsi,
            'is_active' => true,
        ]);

        return redirect()->route('jenis-iuran.index')->with('success', 'Jenis iuran berhasil ditambahkan');
    }

    public function edit(JenisIuran $jenisIuran)
    {
        return view('jenis-iuran.edit', compact('jenisIuran'));
    }

    public function update(Request $request, JenisIuran $jenisIuran)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_iurans,nama,' . $jenisIuran->id,
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'nominal_default' => 'nullable|numeric',
            'denda_per_hari' => 'nullable|numeric|min:0',
            'batas_tanggal' => 'nullable|integer|min:1|max:31',
            'deskripsi' => 'nullable|string',
        ]);

        $jenisIuran->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'icon' => $request->icon ?? $jenisIuran->icon,
            'color' => $request->color ?? $jenisIuran->color,
            'nominal_default' => $request->nominal_default,
            'denda_per_hari' => $request->denda_per_hari ?? $jenisIuran->denda_per_hari,
            'batas_tanggal' => $request->batas_tanggal ?? $jenisIuran->batas_tanggal,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jenis-iuran.index')->with('success', 'Jenis iuran berhasil diupdate');
    }

    public function destroy(JenisIuran $jenisIuran)
    {
        $jenisIuran->delete();
        return redirect()->route('jenis-iuran.index')->with('success', 'Jenis iuran berhasil dihapus');
    }

    public function toggleStatus(JenisIuran $jenisIuran)
    {
        $jenisIuran->update(['is_active' => !$jenisIuran->is_active]);
        return back()->with('success', 'Status jenis iuran berhasil diubah');
    }
}
