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
        
        //Mengambil kas untuk laporan
        $debitKas = Jurnal::select('debit')
                            ->where('referensi', '=', '11')
                            ->get();
        $totalDebitKas = $debitKas->sum('debit');
        $kreditKas = Jurnal::select('kredit')
                            ->where('referensi', '=', '11')
                            ->get();
        $totalKreditKas = $kreditKas->sum('kredit');
        $laporanKas = $totalDebitKas - $totalKreditKas;
        
        //Mengambil piutang untuk laporan
        $debitPiutang = Jurnal::select('debit')
                            ->where('referensi', '=', '12')
                            ->get();
        $totalDebitPiutang = $debitPiutang->sum('debit');
        $kreditPiutang = Jurnal::select('kredit')
                            ->where('referensi', '=', '12')
                            ->get();
        $totalKreditPiutang = $kreditPiutang->sum('kredit');
        $laporanPiutang = $totalDebitPiutang - $totalKreditPiutang;
        
        //Mengambil perlengkapan untuk laporan
        $debitPerlengkapan = Jurnal::select('debit')
                            ->where('referensi', '=', '13')
                            ->get();
        $totalDebitPerlengkapan = $debitPerlengkapan->sum('debit');
        $kreditPerlengkapan = Jurnal::select('kredit')
                            ->where('referensi', '=', '13')
                            ->get();
        $totalKreditPerlengkapan = $kreditPerlengkapan->sum('kredit');
        $laporanPerelengkapan = $totalDebitPerlengkapan - $totalKreditPerlengkapan;
        
        //Mengambil sewa bayar dimuka untuk laporan
        $debitSewa = Jurnal::select('debit')
                            ->where('referensi', '=', '14')
                            ->get();
        $totalDebitSewa = $debitSewa->sum('debit');
        $kreditSewa = Jurnal::select('kredit')
                            ->where('referensi', '=', '14')
                            ->get();
        $totalKreditSewa = $kreditSewa->sum('kredit');
        $laporanSewa = $totalDebitSewa - $totalKreditSewa;
        
        //Mengambil modal dimuka untuk laporan
        $debitModal = Jurnal::select('debit')
                            ->where('referensi', '=', '31')
                            ->get();
        $totalDebitModal = $debitModal->sum('debit');
        $kreditModal = Jurnal::select('kredit')
                            ->where('referensi', '=', '31')
                            ->get();
        $totalKreditModal = $kreditModal->sum('kredit');
        $laporanModal = $totalDebitModal - $totalKreditModal;
        
        //Mengambil modal dimuka untuk laporan
        $debitModal = Jurnal::select('debit')
                            ->where('referensi', '=', '31')
                            ->get();
        $totalDebitModal = $debitModal->sum('debit');
        $kreditModal = Jurnal::select('kredit')
                            ->where('referensi', '=', '31')
                            ->get();
        $totalKreditModal = $kreditModal->sum('kredit');
        $laporanModal = $totalDebitModal - $totalKreditModal;

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
            ->with('laba', rupiah($laba))
            ->with('laporan_kas', rupiah($laporanKas))
            ->with('laporan_piutang', rupiah($laporanPiutang))
            ->with('laporan_perlengkapan', rupiah($laporanPerelengkapan))
            ->with('laporan_sewa', rupiah($laporanSewa))
            ->with('laporan_modal', rupiah($laporanModal));
    }
}