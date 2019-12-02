<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    //
    protected $fillable = [
        'referensi', 'no_transaksi', 'tanggal', 'uraian', 'debit', 'kredit'
    ];

    protected $table = 'jurnal';
    public $timestamps = false;
}
