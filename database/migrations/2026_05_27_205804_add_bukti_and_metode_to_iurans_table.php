<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iurans', function (Blueprint $table) {
            if (!Schema::hasColumn('iurans', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->after('keterangan');
            }
            if (!Schema::hasColumn('iurans', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable()->after('bukti_pembayaran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('iurans', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'metode_pembayaran']);
        });
    }
};
