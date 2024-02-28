<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Tribe;
use App\Models\Kriteria;

class PerhitunganController extends Controller
{
    public function index()
    {
        // Ambil semua tribes
        $tribes = Tribe::all();

        // Ambil semua kriteria
        $kriterias = Kriteria::all();

        // Inisialisasi array untuk menyimpan nilai awal dan nilai akhir per kriteria
        $nilaiPerKriteria = [];

        // Looping setiap tribe
        foreach ($tribes as $tribe) {
            // Inisialisasi nilai awal per tribe
            $nilaiAwalPerTribe = [];

            // Looping setiap kriteria
            foreach ($kriterias as $kriteria) {
                // Ambil penilaian berdasarkan tribe dan kriteria
                $penilaian = Penilaian::where('tribe_id', $tribe->id)
                                        ->where('kriteria_id', $kriteria->id)
                                        ->first();

                // Hitung nilai awal per kriteria
                $nilaiAwal = $penilaian ? $penilaian->nilai : 'Belum dinilai';

                // Hitung nilai akhir per kriteria (nilai awal dikali bobot)
                $nilaiAkhir = $nilaiAwal * $kriteria->bobot;

                // Simpan nilai awal dan nilai akhir per kriteria ke dalam array
                $nilaiAwalPerTribe[$kriteria->id] = $nilaiAwal;
                $nilaiPerKriteria[$tribe->id][$kriteria->id] = $nilaiAkhir;
            }

            // Simpan nilai awal per tribe ke dalam array
            $nilaiPerKriteria[$tribe->id]['nilai_awal'] = $nilaiAwalPerTribe;
        }

        return view('perhitungan', compact('tribes', 'kriterias', 'nilaiPerKriteria'));
    }
}
