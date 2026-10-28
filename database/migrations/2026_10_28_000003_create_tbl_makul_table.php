<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel mata kuliah.
     * kode_makul : kode unik mata kuliah (PK)
     * nama_makul : nama mata kuliah
     * jml_sks    : jumlah SKS
     * jml_cpmk   : jumlah capaian pembelajaran mata kuliah
     */
    public function up(): void
    {
        Schema::create('tbl_makul', function (Blueprint $table) {
            $table->string('kode_makul', 10)->primary();
            $table->string('nama_makul', 50);
            $table->integer('jml_sks');
            $table->integer('jml_cpmk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_makul');
    }
};
