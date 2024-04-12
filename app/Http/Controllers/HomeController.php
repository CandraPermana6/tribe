<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tribe;
use App\Models\Kriteria;
use App\Models\RiwayatPenilaian;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlahTribe = Tribe::count();

        $jumlahKriteria = Kriteria::count();


        // Mengirimkan data ke tampilan 'home.blade.php'
        return view('home', [
            'jumlahTribe' => $jumlahTribe,
            'jumlahKriteria' => $jumlahKriteria,
        ]);
    }
}
