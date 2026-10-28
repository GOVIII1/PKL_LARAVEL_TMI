<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel presensi — rekam kehadiran mahasiswa per pertemuan.
     *
     * id               : primary key auto increment
     * id_pertemuan     : FK → pertemuan.id
     * nim              : FK → mahasiswa.nim
     * status_kehadiran : status kehadiran ('1'=hadir, '2'=izin, '3'=sakit, '4'=alpha), char 1
     */
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pertemuan');
            $table->string('nim', 10);
            $table->char('status_kehadiran', 1);

            $table->foreign('id_pertemuan')
                  ->references('id')
                  ->on('pertemuan')
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
        Schema::dropIfExists('presensi');
    }
};
