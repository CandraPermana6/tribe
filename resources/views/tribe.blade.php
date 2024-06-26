@extends('layouts.dashboard')

@section('content')

<div class="container">

    <h1 class="text-center fw-bold my-5">Daftar Tribe</h1>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card p-3 m-3 shadow ">
        <div class="col-md-3">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTribeModal">
                Add Tribe
            </button>
        </div>
       <div class="table-responsive">
        <table class="table table-borderless table-hover " id="tableData">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Universitas</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tribes as $tribe)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $tribe->nama }}</td>
                        <td>{{ $tribe->jenis_kelamin }}</td>
                        <td>{{ $tribe->universitas }}</td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editTribeModal{{ $tribe->id }}">
                                Edit
                            </button>
                            <form action="{{ route('tribe.destroy', $tribe->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                   <!-- Modal Edit Tribe -->
                   <div class="modal fade" id="editTribeModal{{ $tribe->id }}" tabindex="-1" aria-labelledby="editTribeModalLabel{{ $tribe->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTribeModalLabel{{ $tribe->id }}">Edit Tribe</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('tribe.update', $tribe->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="edit_nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="edit_nama" name="nama" value="{{ $tribe->nama }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <input type="text" class="form-control" id="edit_jenis_kelamin" name="jenis_kelamin" value="{{ $tribe->jenis_kelamin }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_universitas" class="form-label">Universitas</label>
                                        <input type="text" class="form-control" id="edit_universitas" name="universitas" value="{{ $tribe->universitas }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
       </div>
        
    </div>

    <!-- Modal Add Tribe -->
    <div class="modal fade" id="addTribeModal" tabindex="-1" aria-labelledby="addTribeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTribeModalLabel">Add Tribe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('tribe.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="universitas" class="form-label">Universitas</label>
                            <input type="text" class="form-control" id="universitas" name="universitas">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

   
@endsection
