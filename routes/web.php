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

//Ekspedisi
Route::get('/dashboard/ekspedisi', 'EkspedisiController@index');

//SDM
Route::get('/dashboard/sdm', 'SDMController@index');

//TransaksiPembayaran
Route::get('/dashboard/transpem', 'TransPemController@index');