<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Perhitungan</title>
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
    </style>
</head>
<body>
    <h1>Hasil Perhitungan</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Universitas</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($perhitunganSamaTanggal as $perhitungan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $perhitungan->tribe_nama }}</td>
                    <td>{{ $perhitungan->tribe->jenis_kelamin }}</td>
                    <td>{{ $perhitungan->tribe->universitas }}</td>
                    <td>{{ $perhitungan->nilai_akhir }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
