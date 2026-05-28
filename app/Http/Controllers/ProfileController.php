<?php

namespace App\Http\Controllers;
//ini adalah controller profile
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the user profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'bio' => 'nullable|string|max:500',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'bio' => $request->bio
        ];

        $user->update($data);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Hapus avatar lama jika ada
    if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
        Storage::disk('public')->delete('avatars/' . $user->avatar);
    }

    // Upload avatar baru
    $file = $request->file('avatar');
    $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
    $file->storeAs('avatars', $filename, 'public');

    $user->update(['avatar' => $filename]);

    return redirect()->route('profile.edit')->with('success', 'Foto profil berhasil diubah!');
}

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
 * Update the user's kependudukan data.
 */
public function updateKependudukan(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nik' => 'nullable|string|size:16|unique:users,nik,' . $user->id,
        'tempat_lahir' => 'nullable|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'nullable|in:L,P',
        'pekerjaan' => 'nullable|string|max:100',
        'agama' => 'nullable|string|max:50',
        'status_perkawinan' => 'nullable|string|max:50',
    ]);

    $user->update([
        'nik' => $request->nik,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'pekerjaan' => $request->pekerjaan,
        'agama' => $request->agama,
        'status_perkawinan' => $request->status_perkawinan,
    ]);

    return redirect()->route('profile.edit')->with('success', 'Data kependudukan berhasil diperbarui!');
}
}
