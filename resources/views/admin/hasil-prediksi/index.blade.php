@extends('admin.dashboard-admin')

@section('title', 'Data Prediksi')

@section('content')
    <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Prediksi</h1>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>passwor</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Contoh data -->
                                        <tr>
                                            <td>John Doe</td>
                                            <td>john.doe@example.com</td>
                                            <td>08123456789</td>
                                            <td>Jl. Contoh No. 123</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm">Detail</button>
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
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->


            </div>
@endsection