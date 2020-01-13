<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SDM extends Model
{
    //
    protected $table = "sdm";

    protected $fillable = [
        "nik", "nama_karyawan", "alamat_karyawan", "no_telepon", "divisi_pekerjaan",
        "gaji_karyawan", "tanggal_masuk", "email"
    ];

    public $timestamps = false;
}
