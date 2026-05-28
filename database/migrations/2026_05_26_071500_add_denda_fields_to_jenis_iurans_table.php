<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_iurans', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambah
            if (!Schema::hasColumn('jenis_iurans', 'denda_per_hari')) {
                $table->decimal('denda_per_hari', 12, 2)->default(5000)->after('nominal_default');
            }
            if (!Schema::hasColumn('jenis_iurans', 'batas_tanggal')) {
                $table->integer('batas_tanggal')->default(15)->after('denda_per_hari');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jenis_iurans', function (Blueprint $table) {
            $table->dropColumn(['denda_per_hari', 'batas_tanggal']);
        });
    }
};
