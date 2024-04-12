<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Tribe;
use App\Models\Kriteria;
use App\Models\Perhitungan;
use Illuminate\Support\Facades\Redirect;

use Dompdf\Dompdf;
use Dompdf\Options;

class PerhitunganController extends Controller
{
    
    public function index()
    {
        $tribes = Tribe::all();
        $kriterias = Kriteria::all();
        $nilaiPerKriteria = [];
        $totalNilaiAkhirPerTribe = [];
    
        foreach ($tribes as $tribe) {
            $nilaiAwalPerTribe = [];
            $totalNilaiAkhir = 0;
    
            foreach ($kriterias as $kriteria) {
                $penilaian = Penilaian::where('tribe_id', $tribe->id)
                    ->where('kriteria_id', $kriteria->id)
                    ->first();
    
                $nilaiAwal = $penilaian ? $penilaian->nilai : 'Belum dinilai';
                $nilaiAkhir = $nilaiAwal * $kriteria->bobot;
                $totalNilaiAkhir += $nilaiAkhir;
    
                $nilaiAwalPerTribe[$kriteria->id] = $nilaiAwal;
                $nilaiPerKriteria[$tribe->id][$kriteria->id] = $nilaiAkhir;
            }
    
            $nilaiPerKriteria[$tribe->id]['nilai_awal'] = $nilaiAwalPerTribe;
    
            // Simpan total nilai akhir per tribe ke dalam array
            $totalNilaiAkhirPerTribe[$tribe->id] = $totalNilaiAkhir;
        }
    
        return view('perhitungan', compact('tribes', 'kriterias', 'nilaiPerKriteria', 'totalNilaiAkhirPerTribe'));
    }
    

    public function simpan(Request $request)
{
    try {
        $perhitunganSamaJam = $request->perhitungan_sama_jam;

        foreach ($perhitunganSamaJam as $perhitungan) {
            $tribe_id = $perhitungan['tribe']['id']; // Ambil ID tribe dari perhitungan
            $total_nilai_akhir = $perhitungan['total_nilai_akhir']; // Ambil total nilai akhir dari perhitungan

            // Simpan data perhitungan ke dalam database
            $perhitunganBaru = new Perhitungan();
            $perhitunganBaru->tribe_id = $tribe_id;
            $perhitunganBaru->tanggal_perhitungan = now();
            $perhitunganBaru->nilai_akhir = $total_nilai_akhir;
            $perhitunganBaru->save();
        }

        return Redirect::route('perhitungan.riwayat')->with('success', 'Perhitungan berhasil disimpan.');
    } catch (\Exception $e) {
        return response()->json(['message' => 'Terjadi kesalahan saat menyimpan perhitungan.', 'error' => $e->getMessage()], 500);
    }
}



    public function riwayat()
        {
            $riwayatPerhitungan = Perhitungan::all(); // Mendapatkan semua data perhitungan

            return view('riwayat', compact('riwayatPerhitungan'));
        }

        public function perangkingan()
    {
        // Mendapatkan data perangkingan dari model atau sumber data yang sesuai
        $perangkingan = Perhitungan::orderBy('nilai_akhir', 'desc')->get(); // Misalnya, mengambil perangkingan dari tabel Perangkingan dan mengurutkannya berdasarkan nilai secara descending

        // Mengirim data perangkingan ke tampilan 'perangkingan.blade.php'
        return view('riwayat', ['perangkingan' => $perangkingan]);
    }
    public function detailPerangkingan(Request $request)
    {
        $perhitunganId = $request->id;

        // Ambil perhitungan yang sesuai dengan ID yang diberikan
        $perhitungan = Perhitungan::findOrFail($perhitunganId);
        $tanggalPerhitungan = $perhitungan->tanggal_perhitungan;
        $perhitunganSamaTanggal = Perhitungan::where('tanggal_perhitungan', $tanggalPerhitungan)->get();
        $perhitunganSamaTanggal = $perhitunganSamaTanggal->sortByDesc('nilai_akhir');

        // Ambil nama tribe berdasarkan ID tribe pada perhitungan
        foreach ($perhitunganSamaTanggal as $perhitungan) {
            $tribe = Tribe::findOrFail($perhitungan->tribe_id);
            $perhitungan->tribe_nama = $tribe->nama;
        }

        // Kemudian Anda dapat meneruskan data perhitungan ini ke tampilan detail perangkingan
        return view('detail', compact('perhitunganSamaTanggal'));
    }

    public function rangking()
{
    // Ambil semua tribes dan kriteria dari database
    $tribes = Tribe::all();
    $kriterias = Kriteria::all();

    // Inisialisasi array untuk menyimpan data perhitungan
    $perhitunganSamaJam = [];

    // Looping setiap tribe
    foreach ($tribes as $tribe) {
        // Inisialisasi total nilai akhir
        $totalNilaiAkhir = 0;

        // Looping setiap kriteria
        foreach ($kriterias as $kriteria) {
            // Ambil penilaian berdasarkan tribe dan kriteria
            $penilaian = Penilaian::where('tribe_id', $tribe->id)
                ->where('kriteria_id', $kriteria->id)
                ->first();

            // Hitung nilai akhir per kriteria (jika penilaian ada)
            if ($penilaian) {
                $nilaiAwal = $penilaian->nilai;
                $nilaiAkhir = $nilaiAwal * $kriteria->bobot;
                $totalNilaiAkhir += $nilaiAkhir;
            }
        }

        // Simpan data perhitungan per tribe
        $perhitunganSamaJam[] = [
            'tribe' => $tribe,
            'total_nilai_akhir' => $totalNilaiAkhir
        ];
    }

    // Urutkan data perhitungan berdasarkan total nilai akhir dari yang terbesar
    usort($perhitunganSamaJam, function ($a, $b) {
        return $b['total_nilai_akhir'] <=> $a['total_nilai_akhir'];
    });

    // Tampilkan view dengan data perhitungan yang sudah diurutkan
    return view('perangkingan', ['perhitunganSamaJam' => $perhitunganSamaJam]);
}


    public function riwayatPdf($id){
        $perhitungan = Perhitungan::findOrFail($id);
        $tanggalPerhitungan = $perhitungan->tanggal_perhitungan;
        $perhitunganSamaTanggal = Perhitungan::where('tanggal_perhitungan', $tanggalPerhitungan)->get();
        $perhitunganSamaTanggal = $perhitunganSamaTanggal->sortByDesc('nilai_akhir');

        foreach ($perhitunganSamaTanggal as $perhitungan) {
            $tribe = Tribe::findOrFail($perhitungan->tribe_id);
            $perhitungan->tribe_nama = $tribe->nama;
        }

        return $perhitunganSamaTanggal;
        
    }
public function cetakPDF($id)
{
    $perhitunganSamaTanggal = $this->riwayatPdf($id);
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);

    $html = view('perhitungan_pdf', compact('perhitunganSamaTanggal'))->render();

    $dompdf->loadHtml($html);

    $dompdf->render();
    return $dompdf->stream('riwayat_perhitungan.pdf');
}







    }
