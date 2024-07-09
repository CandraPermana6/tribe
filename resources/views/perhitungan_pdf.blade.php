<!DOCTYPE html>
<html>
<head>
    <title>Riwayat</title>
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan Anda */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }

        .badge-success {
            background-color: green;
            color: white;
            padding: 10px 12px;
            border-radius: 12px;
        }

        .badge-danger {
            background-color: red;
            color: white;
            padding:6px 8px;
            border-radius: 8px;
        font-size: 12px;
        }
    </style>
</head>
<body>
    <h1>Nalai tertinggi 1 terpilih sebagai Tribe dan Nilai tertinggi 2 adalah Wakil Tribe </h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Universitas</th>
                <th>Nilai Akhir</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($perhitunganSamaTanggal->take(5) as $index => $perhitungan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $perhitungan->tribe_nama }}</td>
                    <td>{{ $perhitungan->tribe->jenis_kelamin }}</td>
                    <td>{{ $perhitungan->tribe->universitas }}</td>
                    <td>{{ $perhitungan->nilai_akhir }}</td>
                    <td colspan="2">
                        @if ($index == 0 || $index == 1)
                        <span class="badge-success">Terpilih</span>
                    @else 
                        <span class="badge-danger">Tidak Terpilih</span>
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
