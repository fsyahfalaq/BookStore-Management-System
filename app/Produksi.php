<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    //
    // $record->kode_buku    = $request->kode_buku;
    //     $record->berat_buku   = $request->berat_buku;
    //     $record->jumlah_buku  = $request->jumlah_buku;
    //     $record->harga_beli   = $request->harga_beli;
    //     $record->harga_jual   = $request->harga_jual;
    //     $record->tanggal_keluar      = $tanggal_keluar;
    
    protected $fillable = [
        'kode_buku', 'berat_buku', 'jumlah_buku', 'harga_beli', 'harga_jual', 'tanggal_keluar'
    ];

    protected $table = "produksi";
    public $timestamps = false;
}
