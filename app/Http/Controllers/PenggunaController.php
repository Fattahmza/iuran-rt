<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(15);
        return view('pengguna.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('pengguna.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit(User $pengguna)
    {
        $roles = Role::all();
        return view('pengguna.edit', compact('pengguna', 'roles'));
    }

    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pengguna->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = $request->except('password');
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diupdate');
    }

    public function destroy(User $pengguna)
    {
        if ($pengguna->id == auth()->id()) {
            return redirect()->route('pengguna.index')->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }

        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
