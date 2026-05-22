<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengurusRT extends Model
{
    protected $table = 'pengurus_rt';

    protected $fillable = ['user_id', 'jabatan', 'periode', 'tugas', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
