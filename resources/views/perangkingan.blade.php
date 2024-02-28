@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Perangkingan</h1>
    <button id="simpanBtn" class="btn btn-primary">Simpan Perhitungan</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
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
                // Redirect or perform other actions as needed
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan saat menyimpan perhitungan.');
            }
        });
    }
</script>

@endsection
