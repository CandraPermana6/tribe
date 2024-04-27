@extends('layouts.dashboard')

@section('content')
    <h1 class="fw-bold text-center my-5">Daftar Penilaian</h1>

   <div class="card p-3 m-3 shadow">
   

    <table class="table table-borderless" id="tableData">
        <thead>
            <tr>
                <th >No</th>
                <th > Nama Tribe</th>
                @foreach ($kriterias as $kriteria)
                <th  class="form-label">{{ $kriteria->nama }}</th>
        @endforeach
                <th >Action</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($tribes as $tribe)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tribe->nama }}</td>
                @foreach ($kriterias as $kriteria)
                    @php
                        $penilaian = $tribe->penilaians->where('kriteria_id', $kriteria->id)->first();
                        $nilai = $penilaian ? $penilaian->nilai : '-';
                        $teksTombol = $penilaian ? 'Ubah Nilai' : 'Beri Nilai';
                    @endphp

                    <td>{{ $nilai }}</td>
                @endforeach
                <td>
                    <button type="button" class="btn btn-{{ $penilaian ? 'primary' : 'success' }}" data-bs-toggle="modal" data-bs-target="#givePenilaianModal{{ $tribe->id }}">
                        {{ $teksTombol }}
                    </button>
                </td>
            </tr>
        @endforeach
        
        </tbody>
    </table>

    <div class="col-md-2">
        <a href="{{ route('perhitungan.index') }}"  class="btn btn-primary mb-3">Hitung Nilai Awal</a>
    </div>
   </div>

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
