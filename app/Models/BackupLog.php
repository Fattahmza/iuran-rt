<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BackupLog extends Model {
    protected $fillable = ['filename', 'type', 'size', 'created_by'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
