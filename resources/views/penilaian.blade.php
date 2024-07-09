@extends('layouts.dashboard')

@section('content')
    <h1 class="fw-bold text-center my-5">PENILAIAN</h1>

    <div class="card p-3 m-3 shadow">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
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
                    @if ($kriteria->nama === 'Pengalaman')
                        <th colspan="3">{{ $kriteria->nama }}</th>
                    @else
                        <th>{{ $kriteria->nama }}</th>
                    @endif
                @endforeach
                    <th>Action</th>
                </tr>
                <tr>
                    @foreach ($kriterias as $kriteria)
                        @if ($kriteria->nama === 'Pengalaman')
                        <th colspan="2"></th>
                            <th>Project</th>
                            <th>Pelatihan</th>
                            <th>Organisasi</th>
                        <th colspan="4"></th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($tribes as $tribe)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tribe->nama }}</td>
                        @foreach ($kriterias as $kriteria)
                            @if ($kriteria->nama === 'Pengalaman')
                                @foreach ($kriteria->subKriterias as $subKriteria)
                                    @php
                                        $penilaian = $tribe->penilaians
                                            ->where('sub_kriteria_id', $subKriteria->id)
                                            ->first();
                                        $nilai = $penilaian ? $penilaian->nilai : '-';
                                        $teksTombol = $penilaian ? 'Ubah Nilai' : 'Beri Nilai';
                                    @endphp
                                    <td>{{ $nilai }}</td>
                                @endforeach
                            @else
                                @php
                                    $penilaian = $tribe->penilaians->where('kriteria_id', $kriteria->id)->first();
                                    $nilai = $penilaian ? $penilaian->nilai : '-';
                                    $teksTombol = $penilaian ? 'Ubah Nilai' : 'Beri Nilai';
                                @endphp
                                <td>{{ $nilai }}</td>
                            @endif
                        @endforeach
                        <td>
                            <button type="button" class="btn btn-{{ $penilaian ? 'primary' : 'success' }}"
                                data-bs-toggle="modal" data-bs-target="#givePenilaianModal{{ $tribe->id }}">
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
                <span class="text-danger text-small">*Belum bisa dilakukan perhitungan, karena total bobot kriteria kurang
                    dari 100</span>
            </div>
        @endif
    </div>

    <!-- Modal Give Penilaian -->
    @foreach ($tribes as $tribe)
        <div class="modal fade" id="givePenilaianModal{{ $tribe->id }}" tabindex="-1"
            aria-labelledby="givePenilaianModalLabel{{ $tribe->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="givePenilaianModalLabel{{ $tribe->id }}">Beri Penilaian untuk
                            {{ $tribe->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('penilaian.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tribe_id" value="{{ $tribe->id }}">
                            @foreach ($kriterias as $kriteria)
                                @if ($kriteria->nama === 'Pengalaman')
                                    @foreach ($kriteria->subKriterias as $subKriteria)
                                        @php
                                            $penilaian = $tribe->penilaians
                                                ->where('sub_kriteria_id', $subKriteria->id)
                                                ->first();
                                            $nilai = $penilaian ? $penilaian->nilai : '';
                                        @endphp
                                        <div class="mb-3">
                                            <label for="nilai_subkriteria{{ $subKriteria->id }}"
                                                class="form-label">{{ $subKriteria->nama }}</label>
                                            <input type="number" class="form-control"
                                                id="nilai_subkriteria{{ $subKriteria->id }}"
                                                name="nilai_subkriteria{{ $subKriteria->id }}" value="{{ $nilai }}"
                                                min="1" max="100">
                                            <div class="invalid-feedback" id="feedback_{{ $subKriteria->id }}">Nilai harus
                                                antara 1 - 100</div>
                                        </div>
                                    @endforeach
                                @else
                                    @php
                                        $penilaian = $tribe->penilaians->where('kriteria_id', $kriteria->id)->first();
                                        $nilai = $penilaian ? $penilaian->nilai : '';
                                    @endphp
                                    <div class="mb-3">
                                        <label for="nilai_{{ $kriteria->id }}"
                                            class="form-label">{{ $kriteria->nama }}</label>
                                        <input type="number" class="form-control" id="nilai_{{ $kriteria->id }}"
                                            name="nilai_{{ $kriteria->id }}" value="{{ $nilai }}" min="1"
                                            max="100">
                                        <div class="invalid-feedback" id="feedback_{{ $kriteria->id }}">Nilai harus antara
                                            1 - 100</div>
                                    </div>
                                @endif
                            @endforeach
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($kriterias as $kriteria)
                @if ($kriteria->nama === 'pengalaman')
                    @foreach ($kriteria->subKriterias as $subKriteria)
                        const inputField{{ $subKriteria->id }} = document.getElementById(
                            'nilai_{{ $subKriteria->id }}');
                        const feedback{{ $subKriteria->id }} = document.getElementById(
                            'feedback_{{ $subKriteria->id }}');

                        inputField{{ $subKriteria->id }}.addEventListener('input', function() {
                            let value = parseFloat(inputField{{ $subKriteria->id }}.value);
                            if (value < 1 || value > 100) {
                                inputField{{ $subKriteria->id }}.classList.add('is-invalid');
                                feedback{{ $subKriteria->id }}.style.display = 'block';
                            } else {
                                inputField{{ $subKriteria->id }}.classList.remove('is-invalid');
                                feedback{{ $subKriteria->id }}.style.display = 'none';
                            }
                        });
                    @endforeach
                @else
                    const inputField{{ $kriteria->id }} = document.getElementById('nilai_{{ $kriteria->id }}');
                    const feedback{{ $kriteria->id }} = document.getElementById('feedback_{{ $kriteria->id }}');

                    inputField{{ $kriteria->id }}.addEventListener('input', function() {
                        let value = parseFloat(inputField{{ $kriteria->id }}.value);
                        if (value < 1 || value > 100) {
                            inputField{{ $kriteria->id }}.classList.add('is-invalid');
                            feedback{{ $kriteria->id }}.style.display = 'block';
                        } else {
                            inputField{{ $kriteria->id }}.classList.remove('is-invalid');
                            feedback{{ $kriteria->id }}.style.display = 'none';
                        }
                    });
                @endif
            @endforeach
        });
    </script>
@endsection
