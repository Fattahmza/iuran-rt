<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('type');
            $table->bigInteger('size');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('backup_logs'); }
};
