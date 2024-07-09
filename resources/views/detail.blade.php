<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">2 Nilai teratas direkomendasikan menjadi Tribe dan Wakil Tribe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <table class="table table-hover table-bordered">
            <thead class="bg-primary text-white">
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
                                <td>{{$index + 1}}</td>
                                <td>{{ $perhitungan->tribe->nama }}</td>
                                <td>{{ $perhitungan->tribe->jenis_kelamin }}</td>
                                <td>{{ $perhitungan->tribe->universitas }}</td>
                                <td>{{ $perhitungan->nilai_akhir }}</td>
                                <td>
                                    @if ($index == 0 || $index == 1)
                                        <span class="badge bg-success">Terpilih</span>
                                    @else 
                                    <span class="badge bg-danger">Tidak Terpilih</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    </div>
</div>