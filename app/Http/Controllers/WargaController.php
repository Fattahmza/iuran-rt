<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa mengakses halaman ini');
        }

        $query = User::whereHas('role', function($q) {
            $q->where('name', 'warga');
        });

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('nik', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('rt', 'like', "%{$request->search}%")
                  ->orWhere('rw', 'like', "%{$request->search}%");
            });
        }

        $wargas = $query->latest()->paginate(15);
        $wargas->appends($request->all());

        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('warga.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pekerjaan' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
        ]);

        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3,
            'phone' => $request->phone,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'agama' => $request->agama,
            'status_perkawinan' => $request->status_perkawinan,
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
        ]);

        return redirect()->route('warga.index')->with('success', 'Warga berhasil ditambahkan');
    }

    public function edit(User $warga)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('warga.edit', compact('warga'));
    }

    public function update(Request $request, User $warga)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik,' . $warga->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $warga->id,
            'phone' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pekerjaan' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
        ]);

        $data = $request->except('password');
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $warga->update($data);
        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diupdate');
    }

    public function destroy(User $warga)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Warga berhasil dihapus');
    }
}
