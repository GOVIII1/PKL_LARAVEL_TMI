<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perak extends Model
{
    protected $table = 'tbl_akademik';
    protected $primaryKey = 'kode_akd';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'kode_akd',
        'semester',
        'tahun',
        'is_active',
    ];
}
