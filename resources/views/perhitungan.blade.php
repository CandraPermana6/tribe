@extends('layouts.dashboard')

@section('content')
    <h1>Daftar Perhitungan</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Tribe</th>
                <th scope="col">Kriteria</th>
                <th scope="col">Nilai Awal</th>
                <th scope="col">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tribes as $tribe)
                @foreach ($kriterias as $kriteria)
                    <tr>
                        <td>{{ $tribe->nama }}</td>
                        <td>{{ $kriteria->nama }}</td>
                        <td>{{ $nilaiPerKriteria[$tribe->id]['nilai_awal'][$kriteria->id] }}</td>
                        <td>{{ $nilaiPerKriteria[$tribe->id][$kriteria->id] }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
