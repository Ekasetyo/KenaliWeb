@extends('admin.dashboard-admin')

@section('title', 'Data Prediksi')

@section('content')
    <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Visualisasi</h1>

                   
                        <div class="card">
                        <div class="card-header">
                            <h3>Perankingan Variabel Terhadap Risiko Stroke</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="strokeRiskChart"></canvas>
                        </div>
                    </div>
                    <!-- Form Input Data Master -->
                    <!-- Modal Tambah Data User -->
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->


            </div>
@endsection