<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEkspedisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('ekspedisi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_buku');
            $table->string('nama_buku');
            $table->string('cabang_penerima');
            $table->string('alamat_cabang');
            $table->string('no_telp');
            $table->date('tgl_pengiriman');
            $table->string('nama_kurir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ekspedisi');
    }
}
