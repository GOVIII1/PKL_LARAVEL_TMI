<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel periode akademik.
     * kode_akd : kode unik periode (PK)
     * semester  : enum GN (ganjil) / GL (genap)
     * tahun     : tahun akademik (4 digit)
     * is_active : enum 1 (aktif) / 0 (tidak aktif)
     */
    public function up(): void
    {
        Schema::create('tbl_akademik', function (Blueprint $table) {
            $table->string('kode_akd', 10)->primary();
            $table->enum('semester', ['GN', 'GL']);
            $table->char('tahun', 4);
            $table->enum('is_active', ['1', '0']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_akademik');
    }
};
