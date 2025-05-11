@extends('admin.dashboard-admin')

@section('content')
    <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Artikel</h1>

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
                                            <td>John Doe</td>
                                            <td>john.doe@example.com</td>
                                            <td>08123456789</td>
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
                    {{-- <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Master</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('/dashboard/data-master') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama:</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Nomor Telepon:</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Alamat:</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Masukkan alamat" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>

                </div> --}}
                <!-- /.container-fluid -->

            </div>
@endsection