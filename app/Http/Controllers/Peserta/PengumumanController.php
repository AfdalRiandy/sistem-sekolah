<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranAcara;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        // Get events with published results where the user participated
        $pendaftarans = PendaftaranAcara::where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->whereHas('penilaian', function($query) {
                $query->where('is_published', true);
            })
            ->with(['acara', 'penilaian'])
            ->get();
        
        return view('peserta.pengumuman.index', compact('pendaftarans'));
    }
    
    public function show($acaraId)
    {
        // Get the user's registration
        $myPendaftaran = PendaftaranAcara::where('user_id', auth()->id())
            ->where('acara_id', $acaraId)
            ->where('status', 'disetujui')
            ->whereHas('penilaian', function($query) {
                $query->where('is_published', true);
            })
            ->with(['acara', 'penilaian', 'user'])
            ->firstOrFail();
            
        // Get all participants' scores for ranking
        $allScores = PendaftaranAcara::where('acara_id', $acaraId)
            ->where('status', 'disetujui')
            ->whereHas('penilaian', function($query) {
                $query->where('is_published', true);
            })
            ->with(['penilaian', 'user'])
            ->get()
            ->sortByDesc(function($pendaftaran) {
                return $pendaftaran->penilaian->nilai;
            });
            
        // Find participant's rank
        $rank = 0;
        foreach ($allScores as $index => $pendaftaran) {
            if ($pendaftaran->id == $myPendaftaran->id) {
                $rank = $index + 1;
                break;
            }
        }
        
        return view('peserta.pengumuman.show', compact('myPendaftaran', 'allScores', 'rank'));
    }
}