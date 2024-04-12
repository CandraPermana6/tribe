<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Tribe;
use App\Models\Kriteria;

class PenilaianController extends Controller
{
    public function index()
    {
        $tribes = Tribe::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::all()->groupBy(['tribe_id', 'kriteria_id']);

        return view('penilaian', compact('tribes', 'kriterias', 'penilaians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tribe_id' => 'required|exists:tribes,id',
        ]);

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'nilai_') !== false) {
                $kriteria_id = str_replace('nilai_', '', $key);

                Penilaian::updateOrCreate([
                    'tribe_id' => $request->input('tribe_id'),
                    'kriteria_id' => $kriteria_id,
                    'nilai' => $value,
                ]);
            }
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil ditambahkan.');
    }

    

        
}
