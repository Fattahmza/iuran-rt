<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('iurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bulan');
            $table->year('tahun');
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal_bayar');
            $table->enum('status', ['lunas', 'belum', 'pending'])->default('belum');
            $table->enum('jenis', ['iuran_wajib', 'iuran_sukarela', 'denda', 'sumbangan']);
            $table->string('bukti_pembayaran')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('iurans'); }
};
