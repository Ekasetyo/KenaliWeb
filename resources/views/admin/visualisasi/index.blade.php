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
    // Data untuk pie chart
    const ctx = document.getElementById('strokeRiskChart').getContext('2d');
    const strokeRiskChart = new Chart(ctx, {
        type: 'pie', // Jenis grafik
        data: {
            labels: ['Variabel A', 'Variabel B', 'Variabel C', 'Variabel D'], // Ganti dengan nama variabel yang relevan
            datasets: [{
                label: 'Persentase Risiko Stroke',
                data: [30, 25, 20, 25], // Data persentase
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Agar grafik dapat menyesuaikan ukuran
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    enabled: true, // Menampilkan tooltip saat hover
                }
            }
        }
    });

    // Data untuk heatmap
    const heatmapData = [
        { x: 10, y: 10, value: 1 },
        { x: 15, y: 15, value: 2 },
        { x: 20, y: 30, value: 3 },
        // Tambahkan data heatmap lainnya sesuai kebutuhan
    ];

    const heatmapInstance = h337.create({
        container: document.getElementById('heatmapContainer')
    });

    heatmapInstance.setData({
        max: 3,
        data: heatmapData
    });
</script>
@endsection