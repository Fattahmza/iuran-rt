<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iurans', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkan
            if (!Schema::hasColumn('iurans', 'verifikasi_status')) {
                $table->enum('verifikasi_status', ['pending', 'verified', 'rejected'])->default('pending')->after('status');
            }
            if (!Schema::hasColumn('iurans', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->after('verifikasi_status')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('iurans', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            if (!Schema::hasColumn('iurans', 'catatan_verifikasi')) {
                $table->text('catatan_verifikasi')->nullable()->after('verified_at');
            }
            if (!Schema::hasColumn('iurans', 'metode_pembayaran')) {
                $table->enum('metode_pembayaran', ['cash', 'transfer', 'qris', 'other'])->default('cash')->after('bukti_pembayaran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('iurans', function (Blueprint $table) {
            $table->dropColumn(['verifikasi_status', 'verified_by', 'verified_at', 'catatan_verifikasi', 'metode_pembayaran']);
        });
    }
};
