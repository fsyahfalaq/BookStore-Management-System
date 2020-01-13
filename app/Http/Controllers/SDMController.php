<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SDM;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class SDMController extends Controller
{
    //
    public function index() {
        return view('dashboard.sdm');
    }

    public function dataKaryawan() {
        return DataTables::of(SDM::query())
            ->make(true);
    }

    public function store(Request $request) {
        $tanggal_masuk = date("Y-m-d",strtotime($request->tanggal_masuk));

        $record                     = new SDM;
        $record->nik                = $request->nik;
        $record->nama_karyawan      = $request->nama_karyawan;
        $record->alamat_karyawan    = $request->alamat_karyawan; 
        $record->no_telepon         = $request->no_telepon;
        $record->email              = $request->email;
        $record->divisi_pekerjaan   = $request->divisi_pekerjaan;
        $record->gaji_karyawan      = $request->gaji_karyawan;
        $record->tanggal_masuk      = $tanggal_masuk;
        $record->save();

        // 'name' => 'superadmin',
        // 'email' => 'superadmin@gmail.com',
        // 'role' => 'superadmin',
        // 'password' => Hash::make('adminadmin') 
        $user = new User;
        $user->name = $request->nama_karyawan;
        $user->email = $request->email;
        $user->role = $request->divisi_pekerjaan;
        $user->password = Hash::make($request->no_telepon);
        $user->save();

        return redirect('dashboard/sdm')->with('alert-success','record berhasil ditambahkan');
    }
}
