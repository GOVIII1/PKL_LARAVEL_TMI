<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas_makul';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'kode_akd',
        'kode_makul',
        'kode_jurusan',
        'nik',
        'nama_kelas',
        'bobot_persen',
    ];

    public function akademik()
    {
        return $this->belongsTo(Perak::class, 'kode_akd', 'kode_akd');
    }

    public function makul()
    {
        return $this->belongsTo(Matkul::class, 'kode_makul', 'kode_makul');
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'kode_jurusan', 'kode_jurusan');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class,'nik','nik');
    }
}