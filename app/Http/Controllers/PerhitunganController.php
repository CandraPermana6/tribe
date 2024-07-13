<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Tribe;
use App\Models\Kriteria;
use App\Models\Perhitungan;
use App\Models\SubKriteria;
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
    
        // Ambil kriteria dengan nama 'Pengalaman'
        $kriteriaPengalaman = Kriteria::where('nama', 'Pengalaman')->first();
        if ($kriteriaPengalaman) {
            // Ambil semua sub kriteria dari kriteria 'Pengalaman'
            $subKriterias = SubKriteria::where('kriteria_id', $kriteriaPengalaman->id)->get();
        }
    
        foreach ($tribes as $tribe) {
            $nilaiAwalPerTribe = [];
            $totalNilaiAkhir = 0;
            $totalNilaiPengalaman = 0;
            $nilaiAwalPengalaman = 0;
    
            foreach ($kriterias as $kriteria) {
                if ($kriteria->nama === 'Pengalaman' && isset($subKriterias)) {
                    $totalNilaiSubKriteria = 0;
                    $jumlahSubKriteria = 0;
                    
                    foreach ($subKriterias as $subKriteria) {
                        $penilaian = Penilaian::where('tribe_id', $tribe->id)
                            ->where('sub_kriteria_id', $subKriteria->id)
                            ->first();
    
                        $nilaiAwal = $penilaian ? $penilaian->nilai : 0;
                        switch (strtolower($subKriteria->nama)) {
                            case 'project':
                                $nilaiAkhir = $nilaiAwal * 0.2;
                                break;
                            case 'pelatihan':
                                $nilaiAkhir = $nilaiAwal * 0.1;
                                break;
                            case 'organisasi':
                                $nilaiAkhir = $nilaiAwal * 0.05;
                                break;
                            default:
                                $nilaiAkhir = 0;
                                break;
                        }
                        $totalNilaiSubKriteria += $nilaiAwal; // Tambahkan nilai awal sub kriteria
                        $totalNilaiPengalaman += $nilaiAkhir;
                        $jumlahSubKriteria++;
                    }
                    
                    $nilaiAwalPengalaman = $jumlahSubKriteria > 0 ? $totalNilaiSubKriteria / $jumlahSubKriteria : 0; // Rata-rata nilai awal sub kriteria
                    
                    
                    $nilaiAwalPerTribe[$kriteria->id] = $nilaiAwalPengalaman; // Simpan nilai awal pengalaman
                    $nilaiPerKriteria[$tribe->id][$kriteria->id] = $totalNilaiPengalaman;
                    $totalNilaiAkhir += $totalNilaiPengalaman;
                } else {
                    $penilaian = Penilaian::where('tribe_id', $tribe->id)
                        ->where('kriteria_id', $kriteria->id)
                        ->first();
    
                    $nilaiAwal = $penilaian ? $penilaian->nilai : 'Belum dinilai';
                    $nilaiAkhir = $nilaiAwal * $kriteria->bobot;
                    $totalNilaiAkhir += $nilaiAkhir;
    
                    $nilaiAwalPerTribe[$kriteria->id] = $nilaiAwal;
                    $nilaiPerKriteria[$tribe->id][$kriteria->id] = $nilaiAkhir;
                }
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

        return Redirect::route('perhitungan.riwayat')->with('success', 'Berhasil disimpan.');
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

        $kriteriaPengalaman = Kriteria::where('nama', 'Pengalaman')->first();
        if ($kriteriaPengalaman) {
            // Ambil semua sub kriteria dari kriteria 'Pengalaman'
            $subKriterias = SubKriteria::where('kriteria_id', $kriteriaPengalaman->id)->get();
        }
    
        // Looping setiap tribe
        foreach ($tribes as $tribe) {
            $nilaiAwalPerTribe = [];
            $totalNilaiAkhir = 0;
            $totalNilaiPengalaman = 0;
            $nilaiAwalPengalaman = 0;
    
            foreach ($kriterias as $kriteria) {
                if ($kriteria->nama === 'Pengalaman' && isset($subKriterias)) {
                    $totalNilaiSubKriteria = 0;
                    $jumlahSubKriteria = 0;
                    
                    foreach ($subKriterias as $subKriteria) {
                        $penilaian = Penilaian::where('tribe_id', $tribe->id)
                            ->where('sub_kriteria_id', $subKriteria->id)
                            ->first();
    
                        $nilaiAwal = $penilaian ? $penilaian->nilai : 0;
                        switch (strtolower($subKriteria->nama)) {
                            case 'project':
                                $nilaiAkhir = $nilaiAwal * 0.2;
                                break;
                            case 'pelatihan':
                                $nilaiAkhir = $nilaiAwal * 0.1;
                                break;
                            case 'organisasi':
                                $nilaiAkhir = $nilaiAwal * 0.05;
                                break;
                            default:
                                $nilaiAkhir = 0;
                                break;
                        }
                        $totalNilaiSubKriteria += $nilaiAwal; // Tambahkan nilai awal sub kriteria
                        $totalNilaiPengalaman += $nilaiAkhir;
                        $jumlahSubKriteria++;
                    }
                    
                    $nilaiAwalPengalaman = $jumlahSubKriteria > 0 ? $totalNilaiSubKriteria / $jumlahSubKriteria : 0; // Rata-rata nilai awal sub kriteria
                    
                    
                    $nilaiAwalPerTribe[$kriteria->id] = $nilaiAwalPengalaman; // Simpan nilai awal pengalaman
                    $nilaiPerKriteria[$tribe->id][$kriteria->id] = $totalNilaiPengalaman;
                    $totalNilaiAkhir += $totalNilaiPengalaman;
                } else {
                    $penilaian = Penilaian::where('tribe_id', $tribe->id)
                        ->where('kriteria_id', $kriteria->id)
                        ->first();
    
                    $nilaiAwal = $penilaian ? $penilaian->nilai : 'Belum dinilai';
                    $nilaiAkhir = $nilaiAwal * $kriteria->bobot;
                    $totalNilaiAkhir += $nilaiAkhir;
    
                    $nilaiAwalPerTribe[$kriteria->id] = $nilaiAwal;
                    $nilaiPerKriteria[$tribe->id][$kriteria->id] = $nilaiAkhir;
                }
            }
    
            $nilaiPerKriteria[$tribe->id]['nilai_awal'] = $nilaiAwalPerTribe;
    
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
    return $dompdf->stream('hasil.pdf');
}







    }
