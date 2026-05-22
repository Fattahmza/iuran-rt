<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom nik sudah ada, jika belum maka tambahkan
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 20)->unique()->nullable()->after('id');
            }
            
            if (!Schema::hasColumn('users', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('nik');
            }
            
            if (!Schema::hasColumn('users', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }
            
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tanggal_lahir');
            }
            
            if (!Schema::hasColumn('users', 'pekerjaan')) {
                $table->string('pekerjaan')->nullable()->after('jenis_kelamin');
            }
            
            if (!Schema::hasColumn('users', 'agama')) {
                $table->string('agama')->nullable()->after('pekerjaan');
            }
            
            if (!Schema::hasColumn('users', 'status_perkawinan')) {
                $table->string('status_perkawinan')->nullable()->after('agama');
            }
            
            if (!Schema::hasColumn('users', 'rt')) {
                $table->string('rt')->nullable()->after('address');
            }
            
            if (!Schema::hasColumn('users', 'rw')) {
                $table->string('rw')->nullable()->after('rt');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
                       'pekerjaan', 'agama', 'status_perkawinan', 'rt', 'rw'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};