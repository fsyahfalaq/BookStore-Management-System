<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoakunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noakun', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_akun');
            $table->string('no_akun');
        });

        //Aktiva
        DB::table('noakun')->insert([
        'nama_akun' => 'Kas',
        'no_akun' => '11'
        ]);
        DB::table('noakun')->insert([
        'nama_akun' => 'Piutang',
        'no_akun' => '12'
        ]);
        DB::table('noakun')->insert([
        'nama_akun' => 'Perlengkapan',
        'no_akun' => '13'
        ]);
        DB::table('noakun')->insert([
        'nama_akun' => 'Sewa dibayar dimuka',
        'no_akun' => '14'
        ]);
        DB::table('noakun')->insert([
        'nama_akun' => 'Peralatan',
        'no_akun' => '15'
        ]);
        DB::table('noakun')->insert([
        'nama_akun' => 'Akumulasi penyusutan',
        'no_akun' => '19'
        ]);

        //Kewajiban
        DB::table('noakun')->insert([
            'nama_akun' => 'Hutang dagang',
            'no_akun' => '21'
        ]);

        //Modal
        DB::table('noakun')->insert([
            'nama_akun' => 'Modal',
            'no_akun' => '31'
        ]);
        DB::table('noakun')->insert([
            'nama_akun' => 'Prive',
            'no_akun' => '32'
        ]);

        //Beban
        DB::table('noakun')->insert([
            'nama_akun' => 'Pendapatan',
            'no_akun' => '41'
        ]);

        //Beban
        DB::table('noakun')->insert([
            'nama_akun' => 'Beban Perlengkapan',
            'no_akun' => '51'
        ]);
        DB::table('noakun')->insert([
            'nama_akun' => 'Beban Gaji',
            'no_akun' => '52'
        ]);
        DB::table('noakun')->insert([
            'nama_akun' => 'Beban Sewa',
            'no_akun' => '53'
        ]);
        DB::table('noakun')->insert([
            'nama_akun' => 'Beban Listrik',
            'no_akun' => '54'
        ]);
        DB::table('noakun')->insert([
            'nama_akun' => 'Beban Telepon',
            'no_akun' => '55'
        ]);
        DB::table('noakun')->insert([
            'nama_akun' => 'Beban Air',
            'no_akun' => '56'
        ]);
        DB::table('noakun')->insert([
            'nama_akun' => 'Beban Penyusutan',
            'no_akun' => '57'
        ]);
        DB::table('noakun')->insert([
            'nama_akun' => 'Beban Rupa-rupa',
            'no_akun' => '58'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noakun');
    }
}
