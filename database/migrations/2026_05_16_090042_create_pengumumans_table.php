<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->date('date');
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('pengumumans'); }
};
