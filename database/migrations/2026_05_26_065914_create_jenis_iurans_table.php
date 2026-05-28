<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iurans', function (Blueprint $table) {
            if (!Schema::hasColumn('iurans', 'jenis_iuran_id')) {
                $table->foreignId('jenis_iuran_id')->nullable()->after('jenis');
            }
        });
    }

    public function down(): void
    {
        Schema::table('iurans', function (Blueprint $table) {
            $table->dropColumn('jenis_iuran_id');
        });
    }
};
