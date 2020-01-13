<?php

namespace App\Http\Controllers;

use App\Ekspedisi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EkspedisiController extends Controller
{
    //
    public function index() {
        return view('dashboard.ekspedisi');
    }

    public function dataEkspedisi() {
        return DataTables::of(Ekspedisi::query())
                ->make(true);
    }

    public function store(Request $request) {
        $tgl_pengiriman = date("Y-m-d", strtotime($request->tgl_pengiriman));

        $record                  = new Ekspedisi;
        $record->kode_buku       = $request->kode_buku;
        $record->nama_buku       = $request->nama_buku;
        $record->cabang_penerima = $request->cabang_penerima;
        $record->alamat_cabang   = $request->alamat_cabang;
        $record->no_telp         = $request->no_telp;
        $record->tgl_pengiriman  = $tgl_pengiriman;
        $record->nama_kurir      = $request->nama_kurir;
        $record->save();

        return redirect('dashboard/ekspedisi')->with('alert-success','record berhasil ditambahkan');
    }
}
