@extends('user.dashboard-user')

@section('title', 'Laporan dan Visualisasi')

@section('content')
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Laporan dan Visualisasi</h1>

            <!-- DataTables Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Status</th>
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

            

            <!-- Gambar Visualisasi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Visualisasi Grafik</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('images/sample-bar-chart.png') }}" alt="Visualisasi Grafik" class="img-fluid">
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection