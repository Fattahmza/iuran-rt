<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('iurans', function (Blueprint $table) {
            if (!Schema::hasColumn('iurans', 'tipe')) {
                $table->enum('tipe', ['pemasukan', 'pengeluaran', 'transfer'])->default('pemasukan')->after('jenis');
            }
            if (!Schema::hasColumn('iurans', 'kategori_id')) {
                $table->foreignId('kategori_id')->nullable()->after('tipe')->constrained('kategori_transaksis');
            }
        });
    }
    public function down() {
        Schema::table('iurans', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'kategori_id']);
        });
    }
};
