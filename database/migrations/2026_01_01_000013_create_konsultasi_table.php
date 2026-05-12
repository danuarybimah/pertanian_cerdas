<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('penyuluh_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('judul');
            $table->text('pertanyaan');
            $table->string('tanaman')->nullable(); // tanaman yang dikonsultasikan
            $table->enum('status', ['open', 'in_progress', 'answered', 'closed'])->default('open');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
