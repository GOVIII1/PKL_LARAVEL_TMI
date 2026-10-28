<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel detail kelas — daftar mahasiswa yang terdaftar di suatu kelas_makul.
     *
     * id       : primary key auto increment
     * id_klsmk : FK → kelas_makul.id
     * nim      : FK → mahasiswa.nim
     */
    public function up(): void
    {
        Schema::create('detail_kelas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_klsmk');
            $table->string('nim', 10);

            $table->foreign('id_klsmk')
                  ->references('id')
                  ->on('kelas_makul')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('nim')
                  ->references('nim')
                  ->on('mahasiswa')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kelas');
    }
};
