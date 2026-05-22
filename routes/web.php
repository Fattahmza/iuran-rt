<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\KategoriTransaksiController;
use App\Http\Controllers\IuranWargaController;
use App\Http\Controllers\PengurusRTController;
use App\Http\Controllers\DataRTController;
use App\Http\Controllers\LaporanIuranController;
use App\Http\Controllers\LaporanKasController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route untuk split screen login & register
Route::get('/login', function () {
    return view('auth.split-login-register');
})->name('login');

Route::get('/register', function () {
    return view('auth.split-login-register');
})->name('register');

// Route untuk proses login/register (tetap menggunakan controller bawaan)
Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
    Route::patch('/profile/kependudukan', [ProfileController::class, 'updateKependudukan'])->name('profile.update.kependudukan');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========== ROUTE IURAN ==========
Route::middleware(['auth'])->group(function () {
    Route::resource('iuran', IuranController::class);
    Route::get('laporan', [IuranController::class, 'laporan'])->name('iuran.laporan');
    Route::get('export-excel', [IuranController::class, 'exportExcel'])->name('iuran.export');
    Route::get('export-pdf', [IuranController::class, 'exportPDF'])->name('iuran.export-pdf');
});

// ========== ROUTE WARGA ==========
Route::middleware(['auth'])->group(function () {
    Route::resource('warga', WargaController::class);
});

// ========== ROUTE TRANSAKSI ==========
Route::middleware(['auth'])->group(function () {
    Route::resource('transfer', TransferController::class);
    Route::resource('kategori', KategoriTransaksiController::class);
});

// ========== ROUTE MASTER DATA ==========
Route::middleware(['auth'])->group(function () {
    Route::resource('iuran-warga', IuranWargaController::class);
    Route::resource('pengurus-rt', PengurusRTController::class);
    Route::resource('data-rt', DataRTController::class);
});

// ========== ROUTE LAPORAN ==========
Route::middleware(['auth'])->group(function () {
    Route::get('laporan-iuran', [LaporanIuranController::class, 'index'])->name('laporan-iuran.index');
    Route::get('laporan-kas', [LaporanKasController::class, 'index'])->name('laporan-kas.index');
});

// ========== ROUTE PENGATURAN ==========
Route::middleware(['auth'])->group(function () {
    Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::resource('backup', BackupController::class);
    Route::get('backup/download/{id}', [BackupController::class, 'download'])->name('backup.download');
    Route::resource('pengguna', PenggunaController::class);
});

require __DIR__.'/auth.php';
