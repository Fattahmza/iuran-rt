<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanIuranController;
use App\Http\Controllers\LaporanKasController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\IuranWargaController;
use App\Http\Controllers\JenisIuranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.split-login-register');
})->name('login');

Route::get('/register', function () {
    return view('auth.split-login-register');
})->name('register');

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
    Route::patch('/profile/kependudukan', [ProfileController::class, 'updateKependudukan'])->name('profile.update.kependudukan');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========== IURAN ==========
Route::middleware(['auth'])->group(function () {
    Route::get('iuran/verifikasi', [IuranController::class, 'verifikasiIndex'])->name('iuran.verifikasi');
    Route::post('iuran/verifikasi/{iuran}', [IuranController::class, 'verifikasi'])->name('iuran.verifikasi.update');
    Route::get('iuran/bukti/{id}', [IuranController::class, 'showBukti'])->name('iuran.bukti');
    Route::get('iuran/detail-verifikasi/{id}', [IuranController::class, 'getDetailVerifikasi'])->name('iuran.detail.verifikasi');
    Route::post('iuran/proses-verifikasi/{id}', [IuranController::class, 'prosesVerifikasi'])->name('iuran.proses.verifikasi');

    Route::resource('iuran', IuranController::class);
    Route::get('laporan', [IuranController::class, 'laporan'])->name('iuran.laporan');
    Route::get('export-excel', [IuranController::class, 'exportExcel'])->name('iuran.export');
    Route::get('export-pdf', [IuranController::class, 'exportPDF'])->name('iuran.export-pdf');
});

// ========== JENIS IURAN ==========
Route::middleware(['auth'])->group(function () {
    Route::resource('jenis-iuran', JenisIuranController::class);
    Route::patch('jenis-iuran/{jenisIuran}/toggle', [JenisIuranController::class, 'toggleStatus'])->name('jenis-iuran.toggle');
});

// ========== WARGA ==========
Route::middleware(['auth'])->group(function () {
    Route::resource('warga', WargaController::class);
    Route::resource('iuran-warga', IuranWargaController::class);
});

// ========== LAPORAN ==========
Route::middleware(['auth'])->group(function () {
    Route::get('laporan-iuran', [LaporanIuranController::class, 'index'])->name('laporan-iuran.index');
    Route::get('laporan-kas', [LaporanKasController::class, 'index'])->name('laporan-kas.index');
});

// ========== PENGATURAN ==========
Route::middleware(['auth'])->group(function () {
    Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::resource('backup', BackupController::class);
    Route::get('backup/download/{id}', [BackupController::class, 'download'])->name('backup.download');
    Route::resource('pengguna', PenggunaController::class);
});

require __DIR__.'/auth.php';
