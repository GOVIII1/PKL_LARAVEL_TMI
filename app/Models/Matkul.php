<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    protected $table = 'tbl_makul';
    protected $primaryKey = 'kode_makul';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'kode_makul',
        'nama_makul',
        'jml_sks',
        'jml_cpmk',
    ];
}
