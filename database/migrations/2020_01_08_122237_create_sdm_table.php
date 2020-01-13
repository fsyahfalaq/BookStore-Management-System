<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('sdm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nik');
            $table->string('nama_karyawan');
            $table->string('alamat_karyawan');
            $table->string('no_telepon');
            $table->string('email');
            $table->string('divisi_pekerjaan');
            $table->bigInteger('gaji_karyawan');
            $table->date('tanggal_masuk');

            // DB::table('sdm')->insert([
            //     'nik' => 'e002',
            //     'email' => 'jono@gmail.com',
            //     'role' => 'superadmin',
            //     'password' => Hash::make('adminadmin') 
            // ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sdm');
    }
}
