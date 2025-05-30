<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanitiaController extends Controller
{
    public function dashboard()
    {
        return view('panitia.dashboard');
    }
}