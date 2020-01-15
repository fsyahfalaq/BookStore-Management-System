<?php

namespace App\Http\Controllers;

use App\SDM;
use Illuminate\Http\Request;

class TransPemController extends Controller
{
    //
    public function index() {
        return view('dashboard.transpem');
    }

    public function pengeluaran() {
        // $bebanPerlengkapanBulan = Jurnal::select('debit')
        //                     ->where('referensi', '=', '51')
        //                     ->get();
        // $bebanPerlengkapan = $bebanPerlengkapanBulan->sum('debit');
        $getGaji = SDM::select("gaji_karyawan")
                    ->get();
        $gaji = $getGaji->sum("gaji_karyawan");

        return view('dashboard.keuangan.pengeluaran')
                ->with("gaji", $gaji);
    }
}
