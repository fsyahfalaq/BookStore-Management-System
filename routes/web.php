<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\JurnalController;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
// Route::get('/home', 'HomeController@index')->name('home');

//Dashboard
Route::get('/dashboard', 'DashboardController@index');

//Jurnal
Route::get('/dashboard/jurnal', 'JurnalController@index');
Route::get('/dashboard/jurnal/datauser', 'JurnalController@dataUser')->name('datauser');
Route::POST('/dashboard/jurnal', 'JurnalController@store');

//Logistik
Route::get('/dashboard/logistik', 'LogistikController@index');

//Produksi
Route::get('/dashboard/produksi', 'ProduksiController@index');
Route::POST('/dashboard/produksi', 'ProduksiController@store');
Route::get('/dashboard/produksi/data-produksi', 'ProduksiController@dataProduksi')
    ->name('dataProduksi');

//Ekspedisi
Route::get('/dashboard/ekspedisi', 'EkspedisiController@index');
Route::get('/dashboard/ekspedisi/data-ekspedisi', 'EkspedisiController@dataEkspedisi')
    ->name('dataEkspedisi');
Route::POST('dashboard/ekspedisi', 'EkspedisiController@store');

//SDM
Route::get('/dashboard/sdm', 'SDMController@index');
Route::get('/dashboard/sdm/data-karyawan', 'SDMController@dataKaryawan')
    ->name('dataKaryawan');
Route::POST('dashboard/sdm', 'SDMController@store');

//TransaksiPembayaran
Route::get('/dashboard/transpem', 'TransPemController@index');
Route::get('/dashboard/keuangan/pengeluaran', 'TransPemController@pengeluaran');