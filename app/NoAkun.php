<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoAkun extends Model
{
    //
    protected $fillable = [
        'nama_akun', 'no_akun'
    ];

    protected $table = 'noakun';
    public $timestamps = false;
}
