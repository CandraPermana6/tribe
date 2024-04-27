@extends('layouts.dashboard')
@section('content')
<div class="card-shadow  py-5">
    <br/>
    <h3 class="text-center font-weight-bold">Selamat Datang di Sistem Pendukung Keputusan Pemilihan Tribe</h3>
    <br/>
    </div>
    <!-- Begin Page Content -->
    <div class="container-fluid">                       
                <!-- Illustrations -->
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary text-center">Selamat Datang {{ Auth::user()->name }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                src="{{ asset('assets') }}/img/undraw_posting_photo.svg" alt="">
                        </div>
                        <p>Sistem ini bertujuan untuk melakukan pemilihan Tribe Kampus Merdeka pada PT Chakra Giri Energi Indonesia Menggunakan Metode SMART, Adapun fitur pada sistem ini adalah :</p>
                        <h6>- Fitur Data Alternatif</h6>
                        <h6>- Fitur Data Kriteria</h6>
                        <h6>- Fitur Data Penilaian</h6>
                        <h6>- Fitur Proses Perhitungan</h6>
                        <h6>- Fitur Nilai Akhir</h6>
                    </div>
                </div>

    </div>
    <!-- /.container-fluid -->
@endsection