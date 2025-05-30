<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function dashboard()
    {
        return view('peserta.dashboard');
    }
}