<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $kriteria = Kriteria::where('nama', 'pengalaman')->first();

        if ($kriteria) {
            $subKriterias = [
                'project',
                'pelatihan',
                'organisasi',
            ];

            foreach ($subKriterias as $subKriteria) {
                SubKriteria::create([
                    'kriteria_id' => $kriteria->id,
                    'nama' => $subKriteria,
                ]);
            }
        }
    }
}
