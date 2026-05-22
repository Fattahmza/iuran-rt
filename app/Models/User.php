<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'phone', 'address', 'rt', 'rw',
        'avatar', 'bio', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'pekerjaan', 'agama', 'status_perkawinan'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'tanggal_lahir' => 'date'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function iurans()
    {
        return $this->hasMany(Iuran::class);
    }

    // ========== TAMBAHKAN RELASI INI UNTUK PENGURUS RT ==========
    public function pengurus()
    {
        return $this->hasOne(PengurusRT::class);
    }
    // ============================================================

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isBendahara()
    {
        return $this->role && $this->role->name === 'bendahara';
    }

    public function isWarga()
    {
        return $this->role && $this->role->name === 'warga';
    }

    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && Storage::disk('public')->exists('avatars/' . $this->avatar)) {
            return asset('storage/avatars/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?background=4361ee&color=fff&name=' . urlencode($this->name);
    }

    public function getAvatarThumbAttribute()
    {
        if ($this->avatar && Storage::disk('public')->exists('avatars/' . $this->avatar)) {
            return asset('storage/avatars/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?background=4361ee&color=fff&size=40&name=' . urlencode($this->name);
    }

    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : ($this->jenis_kelamin == 'P' ? 'Perempuan' : '-');
    }
}
