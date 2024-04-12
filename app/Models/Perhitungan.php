<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Perhitungan extends Model
{
    use HasFactory;

    protected $fillable = ['tribe_id', 'kriteria_id', 'nilai', 'tanggal_penilaian'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function tribe()
    {
        return $this->belongsTo(Tribe::class);
    }

    public function getNilaiUtilityAttribute()
    {
        $bobot = $this->kriteria->bobot;
        return $this->nilai * $bobot / 100;
    }

    public function getTanggalPerhitunganIndoAttribute()
    {
        return Carbon::parse($this->tanggal_perhitungan)->translatedFormat('l, d F Y ');
    }
}
