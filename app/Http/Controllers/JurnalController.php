<?php

namespace App\Http\Controllers;

use App\Jurnal;
use App\NoAkun;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;
use Validator;
use Yajra\DataTables\DataTables;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no_akun = NoAkun::all();
        $pendapatanBulan = Jurnal::select('debit')
                            ->where('referensi', '=', '11')
                            ->get();
        $pendapatan = $pendapatanBulan->count();
        return view('dashboard.jurnal')
            ->with('no_akun', $no_akun)
            ->with('pendapatan', $pendapatan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dataUser() {
        return  DataTables::of(Jurnal::query())
                        ->make(true);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'uraian'  => 'required',
            'tanggal' => 'required' 
        ];
        
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }
        //convert form date to sql date format
        $tanggal = date("Y-m-d",strtotime($request->tanggal));
        $record = new Jurnal;
        $record->no_transaksi = $request->no_transaksi;
        $record->referensi    = $request->referensi;
        $record->tanggal      = $tanggal;
        $record->uraian       = $request->uraian;
        
        //penentuan debit kredit
        if ($request->jenis_transaksi == 1) {
            $record->debit     = $request->sejumlah;    
        } else if ($request->jenis_transaksi == 2) {
            $record->kredit    = $request->sejumlah;
        }
        
        if ($record->referensi != '41') {
            $record->save();    
        }

        //Otomatisasi beban biaya
        $otomatisasiBiaya = new Jurnal;

        switch ($request->referensi) {
            //Sewa dibayar dimuka
            case '14':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();    
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();
                
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;
            //Peralatan
            case '15':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;
            
            //Pendapatan
            case '41':
                //Menampung nilai pendapatan

                //Penentuan jenis pembayaran
                // "0": Null
                // "1": Tunai
                // "2": Hutang
                // "3": Piutang
                // return var_dump($request->metode_pembayaran);
                if ($request->metode_pembayaran === "3") {
                    //Jika pendapatan yang didapat sepenuhnya bukan piutang 
                    //(terdapat sejumlah uang yang sudah dibayarkan) 
                    if ($request->terbayar != 0) {
                        $kas = new Jurnal;
                        $kas->no_transaksi  = $request->no_transaksi;
                        $kas->referensi     = 11;
                        $kas->tanggal       = $tanggal;
                        $kas->uraian        = "Kas ";
                        $kas->debit         = $request->terbayar;
                        $kas->save();
                    }
                    
                    //Pencatatan piutang
                    $terbayar = new Jurnal;
                    $terbayar->no_transaksi = $request->no_transaksi;
                    $terbayar->referensi    = 12;
                    $terbayar->tanggal      = $tanggal;
                    $terbayar->uraian       = "Piutang ".$request->uraian;
                    $terbayar->debit        = $request->sejumlah - $request->terbayar;
                    $terbayar->save();
                } else {  //Pencatatan kas
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas ".$request->uraian;
                    $otomatisasiBiaya->debit        = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                
                //Pencatatan jurnal kedalam pendapatan
                $pendapatan = new Jurnal;
                $pendapatan->no_transaksi = $request->no_transaksi;
                $pendapatan->referensi    = 41;
                $pendapatan->tanggal      = $tanggal;
                $pendapatan->uraian       = "Pendapatan ".$request->uraian;
                $pendapatan->kredit       = $request->sejumlah;
                $pendapatan->save();
                break;
                
            //Beban Perlengkapan
            case '51':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                //Maka beban perlengkapan akan tercatat pada debit dan hutang pada kredit 
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();                    
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                //Jika jenis pembayarannya hutang dan membayar sejumlah DP
                //Maka beban perlengkapan akan tercatat pada debit dan kas masuk   
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;

            //Beban Gaji    
            case '52':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;

            //Beban sewa
            case '53':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas ";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;

            //Beban listrik
            case '54':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas ";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;

            //Beban telepon
            case '55':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;

            //Beban Air
            case '56':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas ";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;

            //Beban penyusutan
            case '57':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi    = 11;
                    $otomatisasiBiaya->tanggal      = $tanggal;
                    $otomatisasiBiaya->uraian       = "Kas ";
                    $otomatisasiBiaya->kredit       = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;

            //Beban rupa - rupa
            case '58':
                //Jika jenis pembayarannya hutang dan tidak sama sekali melakukan pembayaran
                if (($request->metode_pembayaran === '2') && ($request->DP == 0)) {
                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah;
                    $hutang->save();
                } else if (($request->metode_pembayaran === '2') && ($request->DP != 0)) {
                    $kas = new Jurnal;
                    $kas->no_transaksi  = $request->no_transaksi;
                    $kas->referensi     = 11;
                    $kas->tanggal       = $tanggal;
                    $kas->uraian        = "kas ".$request->uraian;
                    $kas->kredit        = $request->DP;
                    $kas->save();

                    $hutang = new Jurnal;
                    $hutang->no_transaksi = $request->no_transaksi;
                    $hutang->referensi    = 21;
                    $hutang->tanggal      = $tanggal;
                    $hutang->uraian       = "Hutang ".$request->uraian;
                    $hutang->kredit       = $request->sejumlah - $request->DP;
                    $hutang->save();
                } else {
                    $otomatisasiBiaya->no_transaksi = $request->no_transaksi;
                    $otomatisasiBiaya->referensi = 11;
                    $otomatisasiBiaya->tanggal   = $tanggal;
                    $otomatisasiBiaya->uraian    = "Kas ";
                    $otomatisasiBiaya->kredit    = $request->sejumlah;
                    $otomatisasiBiaya->save();
                }
                break;
            
            default:
                # code...
                break;
        }

        // return response()->json($record);
        // return view('dashboard.jurnal')->with('alert-success','record berhasil ditambahkan');
        return redirect('dashboard/jurnal')->with('alert-success','record berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
