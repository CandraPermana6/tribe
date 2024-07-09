<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Tribe;
use App\Models\Kriteria;
use Illuminate\Support\Facades\Log;
class PenilaianController extends Controller
{
    public function index()
    {
        $tribes = Tribe::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::all()->groupBy(['tribe_id', 'kriteria_id']);
        $totalBobotSaatIni = Kriteria::all()->sum('bobot');

        return view('penilaian', compact('tribes', 'kriterias', 'penilaians','totalBobotSaatIni'));
    }

    public function store(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'tribe_id' => 'required|exists:tribes,id',
        // Tambahkan validasi untuk nilai-nilai kriteria/subkriteria di sini
    ]);

    // Proses penyimpanan penilaian
    foreach ($request->all() as $key => $value) {
        if (strpos($key, 'nilai_subkriteria') === 0) {
            $subKriteriaId = substr($key, strlen('nilai_subkriteria'));
            $nilai = $value;

            Penilaian::updateOrCreate(
                [
                    'tribe_id' => $request->tribe_id,
                    'sub_kriteria_id' => $subKriteriaId
                ],
                [
                    'nilai' => $nilai,
                    'kriteria_id' => 1
                ]
            );
        } elseif (strpos($key, 'nilai_') === 0) {
            $kriteriaId = substr($key, strlen('nilai_'));
            $nilai = $value;

            Penilaian::updateOrCreate(
                [
                    'tribe_id' => $request->tribe_id,
                    'kriteria_id' => $kriteriaId
                ],
                [
                    'nilai' => $nilai
                ]
            );
        }
    }

    return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
}

    

    

        
}
