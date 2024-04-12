@extends('layouts.dashboard')

@section('content')
    <h1 class="fw-bold text-center my-5">Daftar Kriteria</h1>

    <div class="card p-3 m-3 shadow">
        <div class="col-md-3">

            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addKriteriaModal">
                Tambah Kriteria
            </button>
        </div>
    
        <table class="table table-hover table-borderless " id="tableData">
            <thead>
                <tr>
                    <th >No</th>
                    <th >Nama</th>
                    <th >Bobot</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kriterias as $kriteria)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $kriteria->nama }}</td>
                        <td>{{ $kriteria->bobot }}</td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editKriteriaModal{{ $kriteria->id }}">
                                Edit
                            </button>
                            <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="editKriteriaModal{{ $kriteria->id }}" tabindex="-1" aria-labelledby="editKriteriaModalLabel{{ $kriteria->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editKriteriaModalLabel{{ $kriteria->id }}">Edit Kriteria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('kriteria.update', $kriteria->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="edit_nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="edit_nama" name="nama" value="{{ $kriteria->nama }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_bobot" class="form-label">Bobot</label>
                                            <input type="text" class="form-control" id="edit_bobot" name="bobot" value="{{ $kriteria->bobot }}">
                                        </div>
                                        <!-- Tambahkan input lain sesuai kebutuhan -->
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Add Kriteria -->
<div class="modal fade" id="addKriteriaModal" tabindex="-1" aria-labelledby="addKriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKriteriaModalLabel">Tambah Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('kriteria.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="mb-3">
                        <label for="bobot" class="form-label">Bobot</label>
                        <input type="text" class="form-control" id="bobot" name="bobot">
                    </div>
                    <!-- Tambahkan input lain sesuai kebutuhan -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
