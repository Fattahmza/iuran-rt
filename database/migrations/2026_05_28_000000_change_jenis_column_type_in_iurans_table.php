<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('iurans') && Schema::hasColumn('iurans', 'jenis')) {
            DB::statement("ALTER TABLE iurans MODIFY jenis VARCHAR(255) NOT NULL");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('iurans') && Schema::hasColumn('iurans', 'jenis')) {
            DB::statement("ALTER TABLE iurans MODIFY jenis ENUM('iuran_wajib','iuran_sukarela','denda','sumbangan') NOT NULL");
        }
    }
};
