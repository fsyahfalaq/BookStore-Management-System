<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    //
    public function index() {
        return view('dashboard.produksi');
    }
}
