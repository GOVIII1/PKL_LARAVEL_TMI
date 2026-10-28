<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel data dosen.
     * nik    : nomor induk karyawan (PK, varchar 10)
     * nama   : nama lengkap dosen
     * kontak : nomor telepon
     * email  : alamat email
     * kelamin: jenis kelamin ('l' / 'p'), char 1
     * img    : path foto (nullable)
     */
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('nik', 10)->primary();
            $table->string('nama', 100);
            $table->string('kontak', 13);
            $table->string('email', 100);
            $table->char('kelamin', 1);
            $table->text('img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
