<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel kelas mata kuliah — penghubung antara periode akademik,
     * mata kuliah, jurusan, dan dosen pengampu.
     *
     * id           : primary key auto increment
     * kode_akd     : FK → tbl_akademik.kode_akd
     * kode_makul   : FK → tbl_makul.kode_makul
     * kode_jurusan : FK → jurusan.kode_jurusan
     * nik          : FK → dosen.nik
     * nama_kelas   : nama kelas
     * bobot_persen : bobot kehadiran dalam persen (default 0)
     */
    public function up(): void
    {
        Schema::create('kelas_makul', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_akd', 10);
            $table->string('kode_makul', 10);
            $table->string('kode_jurusan', 10);
            $table->string('nik', 10);
            $table->string('nama_kelas', 100);
            $table->integer('bobot_persen')->default(0);

            $table->foreign('kode_akd')
                  ->references('kode_akd')
                  ->on('tbl_akademik')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('kode_makul')
                  ->references('kode_makul')
                  ->on('tbl_makul')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('kode_jurusan')
                  ->references('kode_jurusan')
                  ->on('jurusan')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('nik')
                  ->references('nik')
                  ->on('dosen')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_makul');
    }
};
