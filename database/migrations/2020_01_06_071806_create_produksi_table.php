<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_buku')->nullable();
            $table->bigInteger('berat_buku')->nullable();
            $table->string('nama_buku');
            $table->bigInteger('jumlah_buku');
            $table->bigInteger('harga_beli')->nullable();
            $table->bigInteger('harga_jual')->nullable();
            $table->date('tanggal_keluar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produksi');
    }
}
