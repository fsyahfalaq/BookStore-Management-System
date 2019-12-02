<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkspedisiController extends Controller
{
    //
    public function index() {
        return view('dashboard.ekspedisi');
    }
}
