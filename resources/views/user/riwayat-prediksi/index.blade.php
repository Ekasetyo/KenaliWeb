@extends('user.dashboard-user')

@section('title', 'Riwayat Prediksi')

@section('content')
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Riwayat Prediksi</h1>

            <!-- DataTables Riwayat Prediksi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Riwayat Prediksi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Contoh data -->
                                <tr>
                                    <td>Rijal Ganteng</td>
                                    <td>rijalganteng123@example.com</td>
                                    <td>Positif</td>
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

            <!-- Form Riwayat Prediksi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Riwayat Prediksi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ url('/user/riwayat-prediksi') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="positif">Positif</option>
                                <option value="negatif">Negatif</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection