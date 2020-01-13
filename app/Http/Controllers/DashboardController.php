<?php

namespace App\Http\Controllers;

use App\Jurnal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        function rupiah($angka){
	
            $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
            return $hasil_rupiah;
         
        }
        
        //Mengambil jumlah pendapatan
        $pendapatanBulan = Jurnal::select('kredit')
                            ->where('referensi', '=', '41')
                            ->get();
        $pendapatan = $pendapatanBulan->sum('kredit');
        
//         51	Beban Perlengkapan
// 52	Beban Gaji
// 53	Beban Sewa
// 54	Beban Listrik
// 55	Beban Telepon
// 56	Beban Air
// 57	Beban Penyusutan
// 58	Beban Rupa-rupa

        //Mengambil data user

        //Mengambil jumlah beban perlengkapan 51
        $bebanPerlengkapanBulan = Jurnal::select('debit')
                            ->where('referensi', '=', '51')
                            ->get();
        $bebanPerlengkapan = $bebanPerlengkapanBulan->sum('debit');

        //Mengambil jumlah beban gaji 52
        $bebanGajiBulan = Jurnal::select('debit')
                            ->where('referensi', '=', '52')
                            ->get();
        $bebanGaji = $bebanGajiBulan->sum('debit');
        
        //Mengambil jumlah beban sewa 53
        $bebanSewaBulan = Jurnal::select('debit')
                            ->where('referensi', '=', '53')
                            ->get();
        $bebanSewa = $bebanSewaBulan->sum('debit');
        
        //Mengambil jumlah beban listrik 54
        $bebanListrikBulan = Jurnal::select('debit')
                            ->where('referensi', '=', '54')
                            ->get();
        $bebanListrik = $bebanListrikBulan->sum('debit');

        //Mengambil jumlah beban telepon 55
        $bebanTeleponBulan = Jurnal::select('debit')
                            ->where('referensi', '=', '55')
                            ->get();
        $bebanTelepon = $bebanTeleponBulan->sum('debit');

        //Mengambil jumlah beban air 56
        $bebanAirBulan = Jurnal::select('debit')
                            ->where('referensi', '=', '56')
                            ->get();
        $bebanAir = $bebanAirBulan->sum('debit');

        //Mengambil jumlah beban penyusutan 57
        $bebanPenyusutanBulan = Jurnal::select('debit')
                            ->where('referensi', '=', '57')
                            ->get();
        $bebanPenyusutan = $bebanPenyusutanBulan->sum('debit');

        //Laba
        $laba = $pendapatan - $bebanPerlengkapan - $bebanGaji - $bebanSewa - $bebanListrik - $bebanTelepon - $bebanAir - $bebanPenyusutan;


        return view('dashboard.overview')
            ->with('pendapatan', rupiah($pendapatan))
            ->with('beban_perlengkapan', rupiah($bebanPerlengkapan))
            ->with('beban_gaji', rupiah($bebanGaji))
            ->with('beban_sewa', rupiah($bebanSewa))
            ->with('beban_listrik', rupiah($bebanListrik))
            ->with('beban_telepon', rupiah($bebanTelepon))
            ->with('beban_air', rupiah($bebanAir))
            ->with('beban_penyusutan', rupiah($bebanPenyusutan))
            ->with('laba', rupiah($laba));
    }
}