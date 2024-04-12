@extends('layouts.dashboard')

@section('content')
    <h1 class="fw-bold text-center my-5">Riwayat Perhitungan</h1>

    <div class="card p-3 m-3 shadow">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Perhitungan</th>
                    <th scope="col">Tanggal Perhitungan</th>
                    <th scope="col">Detail</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $iteration = 0;
                @endphp
    
                @foreach ($riwayatPerhitungan as $perhitungan)
                    @if ($loop->iteration == 1 || $perhitungan->tanggal_perhitungan != $riwayatPerhitungan[$loop->index - 1]->tanggal_perhitungan)
                        <tr>
                            <td>Perhitungan ke-{{ ++$iteration }}</td>
                            <td>{{ $perhitungan->tanggal_perhitungan_indo }}</td>

                            <td>
                                <button class="btn btn-primary" onclick="showDetail({{ $perhitungan->id }})">Detail</button>
                                <a href="{{ route('cetak-pdf', $perhitungan->id) }}" class="btn btn-success" target="_blank">Cetak PDF</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content " id="detailModalContent">
                {{-- Isi --}}
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function showDetail(perhitunganId) {
            $.ajax({
                url: "{{ route('perhitungan.perangkingan.detail') }}",
                type: "GET",
                data: { id: perhitunganId },
                success: function(response) {
                    $('#detailModalContent').html(response);
                    $('#detailModal').modal('show');
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endsection
