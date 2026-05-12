<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kalender_tanam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komoditas_id')->constrained('komoditas')->onDelete('cascade');
            $table->integer('bulan_tanam'); // 1-12
            $table->integer('durasi_tanam'); // dalam hari
            $table->string('wilayah')->default('Jawa Tengah');
            $table->enum('musim', ['hujan', 'kemarau', 'semua'])->default('semua');
            $table->text('keterangan')->nullable();
            $table->string('varietas')->nullable();
            $table->decimal('produktivitas_rata', 8, 2)->nullable(); // ton/hektar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kalender_tanam');
    }
};
