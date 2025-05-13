@extends('user.dashboard-user')

@section('content')
    <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Artikel</h1>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <a class="collapse-item" href="{{ url('/dashboard/charts') }}">List Data Artikel</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Nomor Telepon</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Contoh data -->
                                        <tr>
                                            <td>Rijal Ganteng</td>
                                            <td>rijalganteng123@example.com</td>
                                            <td>088 sisanya kapan-kapan</td>
                                            <td>Jl. Mastrip No. 123</td>
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
                <!-- /.container-fluid -->

            </div>
@endsection