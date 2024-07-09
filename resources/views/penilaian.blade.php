@extends('layouts.dashboard')

@section('content')
    <h1 class="fw-bold text-center my-5">PENILAIAN</h1>

    <div class="card p-3 m-3 shadow">
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <table class="table table-hover table-bordered">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Id</th>
                    <th>Nama Tribe</th>
                    @foreach ($kriterias as $kriteria)
                        <th>{{ $kriteria->nama }}</th>
                    @endforeach
                    <th>Action</th>
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

        @if ($totalBobotSaatIni > 0.99 && $totalBobotSaatIni < 1.01)
        <div class="col-md-2">
            <a href="{{ route('perhitungan.index') }}" class="btn btn-primary mb-3">Hitung Nilai Awal</a>
        </div>
    @else
        <div class="col-md-6">
            <span class="text-danger text-small">*Belum bisa dilakukan perhitungan, karena total bobot kriteria kurang dari 100</span>
        </div>
    @endif
    

    


        
    
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
                            @php
                                $penilaian = $tribe->penilaians->where('kriteria_id', $kriteria->id)->first();
                            @endphp
                                <div class="mb-3">
                                    <label for="nilai_{{ $kriteria->id }}" class="form-label">{{ $kriteria->nama }}</label>
                                    @if ($kriteria->nama == 'Pengalaman')
                                        <select class="form-control mb-2" id="pengalaman_{{ $kriteria->id }}" name="pengalaman_{{ $kriteria->id }}">
                                            <option value="">-- Pilih jenis pengalaman --</option>
                                            <option value="Project" {{ $penilaian && $penilaian->nilai == 'Project' ? 'selected' : '' }}>Project</option>
                                            <option value="Pelatihan" {{ $penilaian && $penilaian->nilai == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                            <option value="Organisasi" {{ $penilaian && $penilaian->nilai == 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                                        </select>
                                        <input type="number" class="form-control" id="nilai_{{ $kriteria->id }}" name="nilai_{{ $kriteria->id }}" value="{{ $penilaian ? $penilaian->nilai : '' }}" min="1" max="100">
                                    @else
                                        <input type="number" class="form-control" id="nilai_{{ $kriteria->id }}" name="nilai_{{ $kriteria->id }}" value="{{ $penilaian ? $penilaian->nilai : '' }}" min="1" max="100">
                                    @endif
                                    <div class="invalid-feedback" id="feedback_{{ $kriteria->id }}">Nilai harus antara 1 - 100</div>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach ($kriterias as $kriteria)
                    const inputField{{ $kriteria->id }} = document.getElementById('nilai_{{ $kriteria->id }}');
                    const feedback{{ $kriteria->id }} = document.getElementById('feedback_{{ $kriteria->id }}');
                    
                    inputField{{ $kriteria->id }}.addEventListener('input', function () {
                        let value = parseFloat(inputField{{ $kriteria->id }}.value);
                        if (value < 1 || value > 100) {
                            inputField{{ $kriteria->id }}.classList.add('is-invalid');
                            feedback{{ $kriteria->id }}.style.display = 'block';
                        } else {
                            inputField{{ $kriteria->id }}.classList.remove('is-invalid');
                            feedback{{ $kriteria->id }}.style.display = 'none';
                        }
                    });
                @endforeach
            });
        </script>
    @endforeach
@endsection
