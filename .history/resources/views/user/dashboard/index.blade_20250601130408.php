@extends('user.dashboard-user')

@section('title', 'Dashboard')

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Predictions Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Hasil Deteksi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deteksiCount ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konsultasi Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Konsultasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $konsultasiCount ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row -->
            <div class="row">
                <!-- Deteksi Risk Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-success">Hasil Deteksi ({{ date('Y') }})</h6>
                        </div>
                        <div class="card-body">
                            @if (!empty($deteksisPerMonthArray) && array_sum($deteksisPerMonthArray) > 0)
                                <div class="chart-container">
                                    <canvas id="deteksiRiskChart"></canvas>
                                </div>
                            @else
                                <p>Tidak ada data deteksi untuk ditampilkan.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Konsultasi Per Month Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Konsultasi per Bulan ({{ date('Y') }})</h6>
                        </div>
                        <div class="card-body">
                            @if (!empty($konsultasisPerMonthArray) && array_sum($konsultasisPerMonthArray) > 0)
                                <div class="chart-container">
                                    <canvas id="konsultasiChart"></canvas>
                                </div>
                            @else
                                <p>Tidak ada data konsultasi untuk ditampilkan.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Gender Risk Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Distribusi Stroke Berdasarkan Jenis Kelamin</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="genderChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> Laki-laki
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Perempuan
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Variables Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-warning">Top 5 Faktor Penyebab Stroke</h6>
                        </div>
                        <div class="card-body">
                            @if (!empty($topFactors) && count($topFactors) > 0)
                                <div class="chart-container">
                                    <canvas id="factorsChart"></canvas>
                                </div>
                                <p class="text-muted mt-2" style="font-size: 0.9rem;">
                                    <strong>Keterangan:</strong> Grafik menunjukkan faktor yang paling sering muncul pada kasus stroke.
                                    Persentase dihitung dari jumlah kasus stroke yang memiliki faktor tersebut.
                                </p>
                            @else
                                <p>Tidak ada data untuk ditampilkan.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Average Age Risk Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Rata-rata Usia</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="ageChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-danger"></i> Beresiko Stroke
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Tidak Beresiko
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>

    @push('styles')
        <style>
            .chart-container {
                position: relative;
                width: 100%;
                max-height: 300px;
                overflow: hidden;
            }

            .chart-container canvas {
                width: 100% !important;
                height: 100% !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data deteksi per bulan
                const deteksiData = {!! json_encode($deteksisPerMonthArray ?? array_fill(0, 12, 0)) !!};
                const deteksiCanvas = document.getElementById('deteksiRiskChart');
                if (deteksiCanvas && deteksiData.reduce((a, b) => a + b, 0) > 0) {
                    new Chart(deteksiCanvas.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                            datasets: [{
                                label: 'Hasil Deteksi',
                                data: deteksiData,
                                borderColor: 'rgba(40, 167, 69, 1)',
                                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                                fill: true,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                }

                // Data konsultasi per bulan
                const konsultasiData = {!! json_encode($konsultasisPerMonthArray ?? array_fill(0, 12, 0)) !!};
                const konsultasiCanvas = document.getElementById('konsultasiChart');
                if (konsultasiCanvas && konsultasiData.reduce((a, b) => a + b, 0) > 0) {
                    new Chart(konsultasiCanvas.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                            datasets: [{
                                label: 'Konsultasi',
                                data: konsultasiData,
                                borderColor: 'rgba(23, 162, 184, 1)',
                                backgroundColor: 'rgba(23, 162, 184, 0.2)',
                                fill: true,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                }

                // Data jenis kelamin
                const genderData = {!! json_encode($genderData ?? [
                    'Laki-laki' => ['stroke' => 0, 'no_stroke' => 0],
                    'Perempuan' => ['stroke' => 0, 'no_stroke' => 0]
                ]) !!};
                const genderCanvas = document.getElementById('genderChart');
                if (genderCanvas) {
                    new Chart(genderCanvas.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ['Beresiko Stroke', 'Tidak Beresiko'],
                            datasets: [
                                {
                                    label: 'Laki-laki',
                                    backgroundColor: '#4e73df',
                                    data: [
                                        genderData['Laki-laki']['stroke'],
                                        genderData['Laki-laki']['no_stroke']
                                    ]
                                },
                                {
                                    label: 'Perempuan',
                                    backgroundColor: '#1cc88a',
                                    data: [
                                        genderData['Perempuan']['stroke'],
                                        genderData['Perempuan']['no_stroke']
                                    ]
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: { stacked: true },
                                y: { beginAtZero: true }
                            }
                        }
                    });
                }

                // Data usia
                const ageData = {!! json_encode($ageData ?? ['stroke' => 0, 'no_stroke' => 0]) !!};
                const ageCanvas = document.getElementById('ageChart');
                if (ageCanvas) {
                    new Chart(ageCanvas.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ['Rata-rata Usia'],
                            datasets: [
                                {
                                    label: 'Beresiko Stroke',
                                    backgroundColor: '#e74a3b',
                                    data: [ageData['stroke']]
                                },
                                {
                                    label: 'Tidak Beresiko',
                                    backgroundColor: '#36b9cc',
                                    data: [ageData['no_stroke']]
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                }

                // Data faktor risiko
                const topFactors = {!! json_encode($topFactors ?? []) !!};
                const factorsCanvas = document.getElementById('factorsChart');
                if (factorsCanvas && Object.keys(topFactors).length > 0) {
                    new Chart(factorsCanvas.getContext('2d'), {
                        type: 'horizontalBar',
                        data: {
                            labels: Object.keys(topFactors),
                            datasets: [{
                                label: 'Persentase (%)',
                                data: Object.values(topFactors),
                                backgroundColor: '#f6c23e'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        callback: function(value) {
                                            return value + '%';
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection