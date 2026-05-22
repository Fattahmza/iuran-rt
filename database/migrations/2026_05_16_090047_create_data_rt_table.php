<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('data_rt', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rt');
            $table->string('kode_rt');
            $table->string('rw');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('data_rt'); }
};
