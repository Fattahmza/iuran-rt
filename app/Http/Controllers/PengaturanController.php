<?php

namespace App\Http\Controllers;

use App\Models\DataRT;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $dataRT = DataRT::first();
        return view('pengaturan.index', compact('dataRT'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_rt' => 'required|string|max:255',
            'kode_rt' => 'required|string|max:50',
            'rw' => 'required|string|max:10',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        $dataRT = DataRT::first();
        if ($dataRT) {
            $dataRT->update($request->all());
        } else {
            DataRT::create($request->all());
        }

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil disimpan');
    }
}
