<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kategori_iurans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('nominal', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('kategori_iurans'); }
};
