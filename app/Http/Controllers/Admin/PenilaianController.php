<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\PendaftaranAcara;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $acaras = Acara::whereHas('pendaftaran', function($query) {
            $query->where('status', 'disetujui');
        })->latest()->get();
        
        return view('admin.penilaian.index', compact('acaras'));
    }

    public function show($acaraId)
    {
        $acara = Acara::findOrFail($acaraId);
        
        // Get approved participants
        $pendaftarans = PendaftaranAcara::where('acara_id', $acaraId)
            ->where('status', 'disetujui')
            ->with(['user', 'penilaian'])
            ->get();
            
        return view('admin.penilaian.show', compact('acara', 'pendaftarans'));
    }
    
    public function store(Request $request, $pendaftaranId)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        
        $pendaftaran = PendaftaranAcara::findOrFail($pendaftaranId);
        
        Penilaian::updateOrCreate(
            ['pendaftaran_acara_id' => $pendaftaranId],
            [
                'nilai' => $request->nilai,
                'catatan' => $request->catatan,
            ]
        );
        
        return redirect()->back()->with('success', 'Score has been saved successfully.');
    }
    
    public function publish($acaraId)
    {
        $pendaftarans = PendaftaranAcara::where('acara_id', $acaraId)
            ->where('status', 'disetujui')
            ->whereHas('penilaian')
            ->get();
            
        foreach ($pendaftarans as $pendaftaran) {
            if ($pendaftaran->penilaian) {
                $pendaftaran->penilaian->update(['is_published' => true]);
            }
        }
        
        return redirect()->back()->with('success', 'Results have been published successfully.');
    }
}