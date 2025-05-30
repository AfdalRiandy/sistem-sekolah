<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\PendaftaranAcara;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = PendaftaranAcara::with(['user', 'acara']);

        // Apply filters
        if ($request->filled('acara')) {
            $query->where('acara_id', $request->acara);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pendaftaran = $query->latest()->paginate(10);
        $acaras = Acara::all();

        return view('panitia.peserta.index', compact('pendaftaran', 'acaras'));
    }

    public function show(PendaftaranAcara $pendaftaran)
    {
        $pendaftaran->load(['user', 'acara']);
        return view('panitia.peserta.show', compact('pendaftaran'));
    }

    public function approve(PendaftaranAcara $pendaftaran)
    {
        $pendaftaran->update([
            'status' => 'disetujui'
        ]);

        return redirect()->back()->with('success', 'Registration has been approved successfully.');
    }

    public function reject(Request $request, PendaftaranAcara $pendaftaran)
    {
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        $pendaftaran->update([
            'status' => 'gagal',
            'catatan' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Registration has been rejected successfully.');
    }

    public function reset(PendaftaranAcara $pendaftaran)
    {
        $pendaftaran->update([
            'status' => 'menunggu',
            'catatan' => null
        ]);

        return redirect()->back()->with('success', 'Registration has been reset to pending status.');
    }
}