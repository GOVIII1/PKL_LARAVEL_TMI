<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel data jurusan.
     * kode_jurusan : kode unik jurusan (PK)
     * nama_jurusan : nama lengkap jurusan
     */
    public function up(): void
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->string('kode_jurusan', 10)->primary();
            $table->string('nama_jurusan', 30);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};
