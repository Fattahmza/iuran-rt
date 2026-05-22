<?php

namespace App\Http\Controllers;

use App\Models\PengurusRT;
use App\Models\User;
use Illuminate\Http\Request;

class PengurusRTController extends Controller
{
    public function index()
    {
        $pengurus = PengurusRT::with('user')->where('is_active', true)->get();
        $users = User::all();

        return view('pengurus-rt.index', compact('pengurus', 'users'));
    }

    public function create()
    {
        // Ambil user yang belum menjadi pengurus
        $users = User::whereDoesntHave('pengurus')->get();
        return view('pengurus-rt.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jabatan' => 'required|string|max:255',
            'periode' => 'required|string',
            'tugas' => 'nullable|string',
        ]);

        PengurusRT::create($request->all());
        return redirect()->route('pengurus-rt.index')->with('success', 'Pengurus RT berhasil ditambahkan');
    }

    public function edit(PengurusRT $pengurusRt)
    {
        $users = User::all();
        return view('pengurus-rt.edit', compact('pengurusRt', 'users'));
    }

    public function update(Request $request, PengurusRT $pengurusRt)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'periode' => 'required|string',
            'tugas' => 'nullable|string',
        ]);

        $pengurusRt->update($request->all());
        return redirect()->route('pengurus-rt.index')->with('success', 'Pengurus RT berhasil diupdate');
    }

    public function destroy(PengurusRT $pengurusRt)
    {
        $pengurusRt->delete();
        return redirect()->route('pengurus-rt.index')->with('success', 'Pengurus RT berhasil dihapus');
    }
}
