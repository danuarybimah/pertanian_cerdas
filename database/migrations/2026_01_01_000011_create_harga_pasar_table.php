<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harga_pasar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komoditas_id')->constrained('komoditas')->onDelete('cascade');
            $table->decimal('harga', 12, 2); // harga per satuan
            $table->decimal('harga_min', 12, 2)->nullable();
            $table->decimal('harga_max', 12, 2)->nullable();
            $table->string('lokasi_pasar');
            $table->string('wilayah')->default('Jawa Tengah');
            $table->date('tanggal');
            $table->string('sumber')->default('Dinas Pertanian');
            $table->foreignId('input_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harga_pasar');
    }
};
