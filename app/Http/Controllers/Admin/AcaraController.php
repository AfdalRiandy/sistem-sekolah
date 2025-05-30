<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;

class AcaraController extends Controller
{
    public function index()
    {
        $acaras = Acara::latest()->get();
        return view('admin.acara.index', compact('acaras'));
    }

    public function create()
    {
        return view('admin.acara.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal_acara' => 'required|date|after:today',
            'batas_pendaftaran' => 'required|date|before:tanggal_acara',
            'maksimal_peserta' => 'required|integer|min:1',
            'deskripsi_acara' => 'required|string',
        ]);

        Acara::create($request->all());

        return redirect()->route('admin.acara.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit(Acara $acara)
    {
        return view('admin.acara.edit', compact('acara'));
    }

    public function update(Request $request, Acara $acara)
    {
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'batas_pendaftaran' => 'required|date|before:tanggal_acara',
            'maksimal_peserta' => 'required|integer|min:1',
            'deskripsi_acara' => 'required|string',
        ]);

        $acara->update($request->all());

        return redirect()->route('admin.acara.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Acara $acara)
    {
        $acara->delete();

        return redirect()->route('admin.acara.index')
            ->with('success', 'Event deleted successfully.');
    }
}