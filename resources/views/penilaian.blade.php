@extends('layouts.dashboard')

@section('content')
    <h1>Daftar Penilaian</h1>

    <div class="col-md-2">
        <a href="{{ route('perhitungan.index') }}"  class="btn btn-primary mb-3">Hitung Nilai Awal</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tribe</th>
                @foreach ($kriterias as $kriteria)
                <th  class="form-label">{{ $kriteria->nama }}</th>
        @endforeach
                <th scope="col">Action</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($tribes as $tribe)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tribe->nama }}</td>
                @foreach ($kriterias as $kriteria)
                    @php
                        // Ambil penilaian berdasarkan tribe dan kriteria
                        $penilaian = $tribe->penilaians->where('kriteria_id', $kriteria->id)->first();
                        // Cek apakah penilaian sudah ada
                        $nilai = $penilaian ? $penilaian->nilai : '-';
                    @endphp
                    <td>{{ $nilai }}</td>
                @endforeach
                <td>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#givePenilaianModal{{ $tribe->id }}">
                        Beri Nilai
                    </button>
                </td>
            </tr>
        @endforeach
        
        </tbody>
    </table>

    <!-- Modal Give Penilaian -->
    @foreach ($tribes as $tribe)
        <div class="modal fade" id="givePenilaianModal{{ $tribe->id }}" tabindex="-1" aria-labelledby="givePenilaianModalLabel{{ $tribe->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="givePenilaianModalLabel{{ $tribe->id }}">Beri Penilaian untuk {{ $tribe->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('penilaian.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tribe_id" value="{{ $tribe->id }}">
                            @foreach ($kriterias as $kriteria)
                                <div class="mb-3">
                                    <label for="nilai_{{ $kriteria->id }}" class="form-label">{{ $kriteria->nama }}</label>
                                    @if ($kriteria->nama == 'Pengalaman')
                                    <select class="form-control mb-2" id="nilai_{{ $kriteria->id }}" name="nilai_{{ $kriteria->id }}">
                                        <option value="" @readonly(true)>-- Pilih jenis pengalaman --</option>
                                        <option value="Project">Project</option>
                                        <option value="Pelatihan">Pelatihan</option>
                                        <option value="Organisasi">Organisasi</option>
                                    </select>
                                    @endif
                                    <input type="text" class="form-control" id="nilai_{{ $kriteria->id }}" name="nilai_{{ $kriteria->id }}">
                                    
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@endsection
