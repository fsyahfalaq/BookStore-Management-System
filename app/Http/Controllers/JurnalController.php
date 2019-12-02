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
        return view('dashboard.jurnal')
            ->with('no_akun', $no_akun);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dataUser() {
        // $users = DB::table('jurnal')->select('id', 'name', 'email')->get();
        
        // return DataTables::of($users)
        //         ->addIndexColumn()
        //         ->make(true);

        return DataTables::of(Jurnal::query())
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
        $record->referensi = $request->referensi;
        $record->tanggal   = $tanggal;
        $record->uraian    = $request->uraian;
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
        // if ($request->referensi == 51) {
        //     $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
        //     $otomatisasiBiaya->referensi = 11;
        //     $otomatisasiBiaya->tanggal = $tanggal;
        //     $otomatisasiBiaya->uraian = "Kas";
        //     $otomatisasiBiaya->kredit = $request->sejumlah;
        //     $otomatisasiBiaya->save();
        // }

        switch ($request->referensi) {
            case '41':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->debit = $request->sejumlah;
                $otomatisasiBiaya->save();
                $pendapatan = new Jurnal;
                $pendapatan->no_transaksi = $request->no_transaksi+2;
                $pendapatan->referensi = 41;
                $pendapatan->tanggal = $tanggal;
                $pendapatan->uraian = "Pendapatan";
                $pendapatan->kredit = $request->sejumlah;
                $pendapatan->save();
            break;
            case '51':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->kredit = $request->sejumlah;
                $otomatisasiBiaya->save();
                break;
            case '52':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->kredit = $request->sejumlah;
                $otomatisasiBiaya->save();
                break;
            case '53':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->kredit = $request->sejumlah;
                $otomatisasiBiaya->save();
                break;
            case '54':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->kredit = $request->sejumlah;
                $otomatisasiBiaya->save();
                break;
            case '55':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->kredit = $request->sejumlah;
                $otomatisasiBiaya->save();
                break;
            case '56':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->kredit = $request->sejumlah;
                $otomatisasiBiaya->save();
                break;
            case '57':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->kredit = $request->sejumlah;
                $otomatisasiBiaya->save();
                break;
            case '58':
                $otomatisasiBiaya->no_transaksi = $request->no_transaksi+1;
                $otomatisasiBiaya->referensi = 11;
                $otomatisasiBiaya->tanggal = $tanggal;
                $otomatisasiBiaya->uraian = "Kas";
                $otomatisasiBiaya->kredit = $request->sejumlah;
                $otomatisasiBiaya->save();
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
