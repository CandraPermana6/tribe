<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tribe_id',
        'kriteria_id',
        'nilai',
    ];

    public function tribe()
    {
        return $this->belongsTo(Tribe::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
