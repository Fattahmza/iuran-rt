<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('kategori_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['pemasukan', 'pengeluaran']);
            $table->string('icon')->default('fas fa-tag');
            $table->string('color')->default('primary');
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('kategori_transaksis'); }
};
