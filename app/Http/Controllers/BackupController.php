<?php

namespace App\Http\Controllers;

use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $backups = BackupLog::with('creator')->latest()->paginate(15);
        return view('backup.index', compact('backups'));
    }

    public function create()
    {
        try {
            // Backup database
            $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
            $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " > " . storage_path('app/backups/' . $filename);
            system($command);

            BackupLog::create([
                'filename' => $filename,
                'type' => 'database',
                'size' => file_exists(storage_path('app/backups/' . $filename)) ? filesize(storage_path('app/backups/' . $filename)) : 0,
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('backup.index')->with('success', 'Backup database berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->route('backup.index')->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $backup = BackupLog::findOrFail($id);
        $path = storage_path('app/backups/' . $backup->filename);

        if (file_exists($path)) {
            return response()->download($path);
        }

        return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan');
    }

    public function destroy($id)
    {
        $backup = BackupLog::findOrFail($id);
        $path = storage_path('app/backups/' . $backup->filename);

        if (file_exists($path)) {
            unlink($path);
        }

        $backup->delete();
        return redirect()->route('backup.index')->with('success', 'Backup berhasil dihapus');
    }
}
