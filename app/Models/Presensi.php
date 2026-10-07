<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    public $timestamps = false;
    
    protected $fillable = [
        'id_pertemuan',
        'nim',
        'status_kehadiran'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim','nim');
    }

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan', 'id');
    }
}