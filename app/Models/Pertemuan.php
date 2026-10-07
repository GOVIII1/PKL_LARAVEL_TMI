<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $table = 'pertemuan';
    public $timestamps = false;
    protected $fillable = [
        'id_kelas',
        'tanggal',
        'judul_pertemuan',
        'status_presensi',
        'pertemuan_ke'
    ];

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'id_pertemuan', 'id');
    }
}
