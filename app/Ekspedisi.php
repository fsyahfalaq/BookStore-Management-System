<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    //

    protected $fillable = [
        'kode_buku', 'nama_buku', 'cabang penerima', 'alamat cabang', 'no_telp',
        'tgl_pengiriman', 'nama_kurir'
    ];

    public $timestamps = false;
    protected $table = 'ekspedisi';
}
