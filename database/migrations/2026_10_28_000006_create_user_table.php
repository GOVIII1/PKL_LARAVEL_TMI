<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel user untuk autentikasi kustom (bukan tabel users bawaan Laravel).
     * id          : primary key auto increment
     * username    : username login
     * password    : password (hashed)
     * peran       : peran pengguna ('a'=admin, 'd'=dosen, 'm'=mahasiswa), char 10
     * pin         : PIN (hashed), varchar 255
     * last_update : timestamp terakhir diupdate (nullable, default CURRENT_TIMESTAMP)
     * nama        : nama lengkap
     * is_first_login: flag apakah login pertama kali (dari migration sebelumnya)
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 100);
            $table->string('password', 100);
            $table->char('peran', 10);
            $table->string('pin', 255);
            $table->timestamp('last_update')->nullable()->useCurrent();
            $table->string('nama', 100);
            $table->boolean('is_first_login')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
