<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'bobot',
        // tambahkan properti lain sesuai kebutuhan
    ];

    public function setBobotAttribute($value)
    {
        $this->attributes['bobot'] = $value / 100;
    }
}
