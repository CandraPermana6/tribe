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
    // Validasi form data
    $request->validate([
        'tribe_id' => 'required|exists:tribes,id',
        'nilai_*' => 'required' // validasi semua nilai
    ]);

    // Proses penilaian dan perbarui
    foreach ($request->all() as $key => $value) {
        if (strpos($key, 'nilai_') !== false) {
            $kriteria_id = str_replace('nilai_', '', $key);

            try {
                Penilaian::updateOrCreate([
                    'tribe_id' => $request->input('tribe_id'),
                    'kriteria_id' => $kriteria_id,
                ], [
                    'nilai' => $value,
                ]);
            } catch (\Exception $e) {
                Log::error('Error updating penilaian: ' . $e->getMessage());
                // Handle error appropriately (e.g., flash message, redirect)
            }
        }
    }

    // Redirect and display success message
    return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui.');
}

    

        
}
