<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\PendaftaranAcara;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        $acaras = Acara::with(['pendaftaran' => function($query) {
            $query->with('user');
        }])->latest()->get();
        
        return view('admin.peserta.index', compact('acaras'));
    }

    public function show($acaraId)
    {
        $acara = Acara::findOrFail($acaraId);
        
        // Get only approved participants
        $pendaftarans = PendaftaranAcara::where('acara_id', $acaraId)
            ->where('status', 'disetujui')
            ->with('user')
            ->get();
            
        return view('admin.peserta.show', compact('acara', 'pendaftarans'));
    }
    
    public function export($acaraId)
    {
        // Implementation for exporting to Excel
        // This is a placeholder - you would implement this with Laravel Excel or similar
        return redirect()->back()->with('success', 'Export to Excel feature will be implemented soon.');
    }
    
    public function pdf($acaraId)
    {
        // Implementation for exporting to PDF
        // This is a placeholder - you would implement this with a PDF library
        return redirect()->back()->with('success', 'Export to PDF feature will be implemented soon.');
    }
}