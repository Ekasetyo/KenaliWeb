@extends('admin.dashboard-admin')

@section('title', 'Data Saran')

@section('content')
    <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Saran</h1>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">List Data Saran</h6>
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#formTambahSaran">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Pemberi</th>
                                            <th>Saran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Contoh data -->
                                        <tr>
                                            <td>John Doe</td>
                                            <td>Jl. Contoh No. 123</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm">Edit</button>
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </td>
                                        </tr>
                                        <!-- Tambahkan data lainnya di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Form Input Data Master -->
                    <!-- Modal Tambah Data User -->
                    @include('admin.saran.create')
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->


            </div>
@endsection