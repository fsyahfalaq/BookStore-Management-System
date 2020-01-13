<?php

namespace App\Http\Controllers;

use App\Jurnal;
use Illuminate\Http\Request;
use App\Produksi;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProduksiController extends Controller
{
    //
    public function index() {
        return view('dashboard.produksi');
    }

    public function dataProduksi() {
        return DataTables::of(Produksi::query())
            ->make(true);
    }

    public function store(Request $request) {
        //convert form date to sql date format
        $tanggal_keluar = date("Y-m-d",strtotime($request->tanggal_keluar));
        
        $record                     = new Produksi;
        $record->kode_buku          = $request->kode_buku;
        $record->berat_buku         = $request->berat_buku;
        $record->nama_buku          = $request->nama_buku;
        $record->jumlah_buku        = $request->jumlah_buku;
        $record->harga_beli         = $request->harga_beli;
        $record->harga_jual         = $request->harga_jual;
        $record->tanggal_keluar     = $tanggal_keluar;
        $record->save();

        $tanggal = date("Y-m-d",strtotime($request->tanggal));
        $debit = new Jurnal;
        $debit->no_transaksi = "P-".$request->kode_buku;
        $debit->referensi    = "13";
        $debit->tanggal      = date("Y-m-d");
        $debit->uraian       = "Produksi ".$request->kode_buku;
        $debit->debit        = $request->harga_beli * $request->jumlah_buku;
        $debit->save();
 
        $kredit = new Jurnal;
        $kredit->no_transaksi = "P-".$request->kode_buku;
        $kredit->referensi    = "11";
        $kredit->tanggal      = date("Y-m-d");
        $kredit->uraian       = "Produksi ".$request->kode_buku;
        $kredit->kredit        = $request->harga_beli * $request->jumlah_buku;
        $kredit->save();

        return redirect('dashboard/produksi')->with('alert-success','record berhasil ditambahkan');
    }
}
