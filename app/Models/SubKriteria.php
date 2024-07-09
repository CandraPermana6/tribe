<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;
    protected $fillable = ['kriteria_id', 'nama'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
