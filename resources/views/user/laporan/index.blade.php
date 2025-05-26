@extends('user.dashboard-user')

@section('title', 'Laporan dan Visualisasi')

@section('content')
<div id="content">
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Riwayat Prediksi dan Visualisasi</h1>

        <!-- DataTables Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jenis Kelamin</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Prediksi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>682da324db8decc0965b42d7</td>
                                <td>Laki-laki</td>
                                <td>Pegawai Swasta</td>
                                <td>anda beresiko terkena stroke</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal1">Detail</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal1" tabindex="-1" aria-labelledby="detailModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel1">Detail Hasil Deteksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>ID</label>
                                <input type="text" class="form-control" value="682da324db8decc0965b42d7" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>User ID</label>
                                <input type="text" class="form-control" value="68269640854cd324de00c0f6" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Jenis Kelamin</label>
                                <input type="text" class="form-control" value="Laki-laki" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Usia</label>
                                <input type="text" class="form-control" value="75" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Hipertensi</label>
                                <input type="text" class="form-control" value="Ya" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Penyakit Jantung</label>
                                <input type="text" class="form-control" value="Ya" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Pernah Menikah</label>
                                <input type="text" class="form-control" value="Ya" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Jenis Pekerjaan</label>
                                <input type="text" class="form-control" value="Pegawai Swasta" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Tipe Tempat Tinggal</label>
                                <input type="text" class="form-control" value="Perkotaan" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Glukosa</label>
                                <input type="text" class="form-control" value="180" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>BMI</label>
                                <input type="text" class="form-control" value="25" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Status Merokok</label>
                                <input type="text" class="form-control" value="Dulu Pernah" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Prediksi</label>
                                <input type="text" class="form-control" value="anda beresiko terkena stroke" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="text" class="form-control" value="21-05-2025 16:55" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

    </div>
</div>
@endsection