@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="fw-bold text-center my-5">Perangkingan</h1>
    <div class="card p-3 m-3 shadow">
        <div class="col-md-3">

            <button id="simpanBtn" class="btn btn-primary mb-3">Simpan Perhitungan</button>
        </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tribe</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Universitas</th>
                <th scope="col">Total Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($perhitunganSamaJam as $index => $perhitungan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $perhitungan['tribe']->nama }}</td>
                <td>{{ $perhitungan['tribe']->jenis_kelamin }}</td>
                <td>{{ $perhitungan['tribe']->universitas }}</td>
                <td>{{ $perhitungan['total_nilai_akhir'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#simpanBtn').click(function() {
            simpanPerhitungan();
        });
    });

    function simpanPerhitungan() {
        var perhitunganSamaJam = {!! json_encode($perhitunganSamaJam) !!};

        $.ajax({
            url: "{{ route('perhitungan.simpan') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                perhitungan_sama_jam: perhitunganSamaJam
            },
            success: function(response) {
                alert('Perhitungan berhasil disimpan.');
                window.location.href = '/riwayat-perhitungan';
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan saat menyimpan perhitungan.');
            }
        });
    }
</script>

@endsection
