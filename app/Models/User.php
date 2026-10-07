<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'peran',
        'pin',
        'nama',
    ];

    protected $hidden = [
        'password',
        'pin',
    ];
}
