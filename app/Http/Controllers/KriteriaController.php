<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index()
    {
        $totalBobotSaatIni = Kriteria::all()->sum('bobot');
        $kriterias = Kriteria::all();
        return view('kriteria', compact('kriterias','totalBobotSaatIni'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'bobot' => 'required|numeric|min:0|max:100',
        ]);
    
        $bobotBaru = $request->input('bobot');
        $totalBobotSaatIni = Kriteria::sum('bobot');
        $total = $totalBobotSaatIni * 100;
    
        $totalBobotBaru = $total + $bobotBaru;
    
        if ($totalBobotBaru > 100) {
            return redirect()->back()->withErrors(['bobot' => 'Total bobot tidak boleh melebihi 100']);
        }
    
        Kriteria::create($request->all());
    
        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }
    

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::find($id);
    
        $request->validate([
            'nama' => 'required',
            'bobot' => 'required|numeric|min:0|max:100',
        ]);
    
        $bobotBaru = $request->input('bobot');
    
        $totalBobotSaatIni = Kriteria::where('id', '!=', $id)->sum('bobot');
       $total = $totalBobotSaatIni * 100;
    
        $totalBobotBaru = $total + $bobotBaru;
       
        if ($totalBobotBaru > 100) {
            return redirect()->back()->withErrors(['bobot' => 'Total bobot tidak boleh melebihi 100']);
        }
    
        $kriteria->update([
            'nama' => $request->input('nama'),
            'bobot' => $bobotBaru,
        ]);
    
        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui');
    }
    

    public function destroy($id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->delete();

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus');
    }
}
