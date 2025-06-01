@extends('admin.dashboard-admin')

@section('title', 'Data Prediksi')

@section('content')
<div id="content">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Visualisasi</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Persentase Variabel Terhadap Risiko Stroke</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="strokeRiskChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Heatmap</h3>
                    </div>
                    <div class="card-body">
                        <div id="heatmapContainer" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

</div>

<script>
@endsection