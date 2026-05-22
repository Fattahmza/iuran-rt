<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iurans', function (Blueprint $table) {
            // Update enum jenis untuk menambahkan pengeluaran
            DB::statement("ALTER TABLE iurans MODIFY COLUMN jenis ENUM('iuran_wajib', 'iuran_sukarela', 'denda', 'sumbangan', 'pengeluaran') DEFAULT 'iuran_wajib'");
        });
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE iurans MODIFY COLUMN jenis ENUM('iuran_wajib', 'iuran_sukarela', 'denda', 'sumbangan') DEFAULT 'iuran_wajib'");
    }
};
