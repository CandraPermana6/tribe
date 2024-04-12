@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="fw-semibold text-center my-5">Daftar Perhitungan</h1>
    <div class="card p-3 m-3 shadow">
        <div class="col-md-3">

            <a href="{{ route('perhitungan.rangking') }}" class="btn btn-primary">Lihat Perangkingan</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nama Tribe</th>
                    <th scope="col">Kriteria</th>
                    <th scope="col">Nilai Awal</th>
                    <th scope="col">Nilai Akhir</th>
                    <th scope="col">Total Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tribes as $tribe)
                    @php $totalNilaiAkhirTribe = 0; @endphp
                    @foreach ($kriterias as $kriteria)
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ count($kriterias) }}">{{ $tribe->nama }}</td>
                            @endif
                            <td>{{ $kriteria->nama }}</td>
                            <td>{{ $nilaiPerKriteria[$tribe->id]['nilai_awal'][$kriteria->id] }}</td>
                            <td>{{ $nilaiPerKriteria[$tribe->id][$kriteria->id] }}</td>
                        </tr>
                        @php
                            $totalNilaiAkhirTribe += $nilaiPerKriteria[$tribe->id][$kriteria->id];
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <td><strong>Total Nilai Akhir</strong></td>
                        <td class="fw-bold fs-5">{{ $totalNilaiAkhirTribe }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection
