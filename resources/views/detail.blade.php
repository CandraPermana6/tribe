<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detail Perangkingan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h5>Perangkingan Tribe (Nilai Tertinggi sampai Terendah):</h5>
        <ol id="rankingList">
            @foreach ($perhitunganSamaTanggal as $perhitungan)
    <li>{{ $perhitungan->tribe->nama }} - {{ $perhitungan->tribe->jenis_kelamin }} - {{ $perhitungan->tribe->universitas }} - Nilai Akhir: {{ $perhitungan->nilai_akhir }}</li>
@endforeach

        </ol>
    </div>
</div>
