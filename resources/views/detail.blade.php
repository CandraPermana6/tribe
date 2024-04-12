<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Perangkingan Tribe (Nilai Tertinggi sampai Terendah)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
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
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $perhitungan->tribe->nama }}</td>
                                <td>{{ $perhitungan->tribe->jenis_kelamin }}</td>
                                <td>{{ $perhitungan->tribe->universitas }}</td>
                                <td>{{ $perhitungan->nilai_akhir }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    </div>
</div>