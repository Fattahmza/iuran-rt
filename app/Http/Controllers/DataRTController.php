<?php

namespace App\Http\Controllers;

use App\Models\DataRT;
use Illuminate\Http\Request;

class DataRTController extends Controller
{
    public function index()
    {
        $dataRT = DataRT::first();
        return view('data-rt.index', compact('dataRT'));
    }

    public function create()
    {
        return view('data-rt.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rt' => 'required|string|max:255',
            'kode_rt' => 'required|string|max:50',
            'rw' => 'required|string|max:10',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
        ]);

        DataRT::create($request->all());
        return redirect()->route('data-rt.index')->with('success', 'Data RT berhasil ditambahkan');
    }

    public function edit(DataRT $dataRt)
    {
        return view('data-rt.edit', compact('dataRt'));
    }

    public function update(Request $request, DataRT $dataRt)
    {
        $request->validate([
            'nama_rt' => 'required|string|max:255',
            'kode_rt' => 'required|string|max:50',
            'rw' => 'required|string|max:10',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
        ]);

        $dataRt->update($request->all());
        return redirect()->route('data-rt.index')->with('success', 'Data RT berhasil diupdate');
    }

    public function destroy(DataRT $dataRt)
    {
        $dataRt->delete();
        return redirect()->route('data-rt.index')->with('success', 'Data RT berhasil dihapus');
    }
}
