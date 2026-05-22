<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model {
    protected $table = 'pengumumans';
    protected $fillable = ['title', 'content', 'date', 'created_by', 'is_pinned', 'is_active'];
    protected $casts = ['date' => 'date', 'is_pinned' => 'boolean', 'is_active' => 'boolean'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
