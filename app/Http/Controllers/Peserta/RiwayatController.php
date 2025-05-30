<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranAcara;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $pendaftaran = PendaftaranAcara::where('user_id', auth()->id())
            ->with('acara')
            ->latest()
            ->get();

        return view('peserta.riwayat.index', compact('pendaftaran'));
    }
}