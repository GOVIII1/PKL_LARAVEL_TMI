<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKelas extends Model
{
    use HasFactory;

    protected $table = 'detail_kelas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_klsmk',
        'nim',
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_klsmk', 'id');
    }
}