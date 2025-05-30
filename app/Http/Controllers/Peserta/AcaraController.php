<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\PendaftaranAcara;
use Illuminate\Http\Request;

class AcaraController extends Controller
{
    public function index()
    {
        $acaras = Acara::latest()->get();
        return view('peserta.acara.index', compact('acaras'));
    }

    public function show(Acara $acara)
    {
        return view('peserta.acara.show', compact('acara'));
    }

    public function daftar(Request $request, Acara $acara)
    {
        // Check if registration deadline has passed
        if (now()->gt($acara->batas_pendaftaran)) {
            return redirect()->back()->with('error', 'Registration deadline has passed.');
        }

        // Check if the event is full
        if ($acara->pendaftaran->count() >= $acara->maksimal_peserta) {
            return redirect()->back()->with('error', 'This event has reached its maximum number of participants.');
        }

        // Check if user already registered
        $existingRegistration = PendaftaranAcara::where('user_id', auth()->id())
            ->where('acara_id', $acara->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->back()->with('error', 'You have already registered for this event.');
        }

        // Create registration
        PendaftaranAcara::create([
            'user_id' => auth()->id(),
            'acara_id' => $acara->id,
            'status' => 'menunggu',
        ]);

        return redirect()->back()->with('success', 'You have successfully registered for this event. Please wait for approval.');
    }

    public function batalkan(PendaftaranAcara $pendaftaran)
    {
        // Ensure only the owner can cancel
        if ($pendaftaran->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to cancel this registration.');
        }

        // Check if status is still pending
        if ($pendaftaran->status != 'menunggu') {
            return redirect()->back()->with('error', 'You can only cancel pending registrations.');
        }

        // Check if registration deadline has passed
        if (now()->gt($pendaftaran->acara->batas_pendaftaran)) {
            return redirect()->back()->with('error', 'Registration deadline has passed. You cannot cancel anymore.');
        }

        $pendaftaran->delete();

        return redirect()->back()->with('success', 'Your registration has been canceled successfully.');
    }
}