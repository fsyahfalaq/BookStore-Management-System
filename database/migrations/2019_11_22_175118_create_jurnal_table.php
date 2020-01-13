<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurnalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('referensi')->nullable();
            $table->string('no_transaksi');
            $table->date('tanggal');
            $table->string('uraian');
            $table->bigInteger('debit')->nullable();
            $table->bigInteger('kredit')->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnal');
    }
}
