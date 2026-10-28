<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel pertemuan — setiap sesi/pertemuan dari sebuah kelas_makul.
     *
     * id              : primary key auto increment
     * id_kelas        : FK → kelas_makul.id
     * tanggal         : tanggal pertemuan
     * judul_pertemuan : topik/judul pertemuan
     * status_presensi : status presensi ('0'=belum dibuka, '1'=sudah dibuka), char 1
     * pertemuan_ke    : urutan pertemuan (ke-1, ke-2, dst)
     */
    public function up(): void
    {
        Schema::create('pertemuan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kelas');
            $table->date('tanggal');
            $table->string('judul_pertemuan', 255);
            $table->char('status_presensi', 1);
            $table->integer('pertemuan_ke');

            $table->foreign('id_kelas')
                  ->references('id')
                  ->on('kelas_makul')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan');
    }
};
