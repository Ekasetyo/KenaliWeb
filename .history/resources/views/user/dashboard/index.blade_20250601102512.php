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
                            <h6 class="m-0 font-weight-bold text-success">Hasil Deteksi (Juni 2025)</h6>
                        </div>
                        <div class="card-body">
                            @if (!empty($deteksiRisk) && array_sum($deteksiRisk) > 0)
                                <canvas id="deteksiRiskChart"></canvas>
                            @else
                                <p>Tidak ada data deteksi untuk ditampilkan.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Konsultasi Per Day Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Konsultasi per Hari (Juni 2025)</h6>
                        </div>
                        <div class="card-body">
                            @if (!empty($konsultasiPerDay) && array_sum($konsultasiPerDay) > 0)
                                <canvas id="konsultasiChart"></canvas>
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
                            <h6 class="m-0 font-weight-bold text-primary">Jenis Kelamin Beresiko Stroke</h6>
                        </div>
                        <div class="card-body">
                            @if (!empty($genderRisk) && array_sum($genderRisk) > 0)
                                <canvas id="genderRiskChart"></canvas>
                            @else
                                <p>Tidak ada data untuk ditampilkan.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Top Variables Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-warning">Top 5 Variabel Penyebab Stroke</h6>
                        </div>
                        <div class="card-body">
                            @if (!empty($topVariables) && count($topVariables) > 0)
                                <canvas id="topVariablesChart"></canvas>
                            @else
                                <p>Tidak ada data untuk ditampilkan.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deteksiRisk = {!! json_encode($deteksiRisk ?? ['Beresiko' => 0, 'Tidak Beresiko' => 0]) !!};
                const konsultasiPerDay = {!! json_encode($konsultasiPerDay ?? array_fill(0, 31, 0)) !!};
                const genderRisk = {!! json_encode($genderRisk ?? ['Laki-laki' => 0, 'Perempuan' => 0]) !!};
                const topVariables = {!! json_encode($topVariables ?? []) !!};

                console.log('Deteksi Risk:', deteksiRisk);
                console.log('Konsultasi Per Day:', konsultasiPerDay);
                console.log('Gender Risk:', genderRisk);
                console.log('Top Variables:', topVariables);

                const deteksiCanvas = document.getElementById('deteksiRiskChart');
                if (deteksiCanvas && deteksiRisk.Beresiko + deteksiRisk['Tidak Beresiko'] > 0) {
                    new Chart(deteksiCanvas.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Beresiko', 'Tidak Beresiko'],
                            datasets: [{
                                data: [deteksiRisk.Beresiko, deteksiRisk['Tidak Beresiko']],
                                backgroundColor: ['rgba(255, 99, 132, 0.8)', 'rgba(75, 192, 192, 0.8)'],
                                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                const konsultasiCanvas = document.getElementById('konsultasiChart');
                if (konsultasiCanvas && konsultasiPerDay.reduce((a, b) => a + b, 0) > 0) {
                    new Chart(konsultasiCanvas.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: Array.from({length: 31}, (_, i) => (i + 1).toString()),
                            datasets: [{
                                label: 'Konsultasi',
                                data: konsultasiPerDay,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: true,
                                tension: 0.1,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true, grid: { display: false }, title: { display: true, text: 'Jumlah' } },
                                x: { grid: { display: false }, title: { display: true, text: 'Tanggal' } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return 'Konsultasi: ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                const genderCanvas = document.getElementById('genderRiskChart');
                if (genderCanvas && genderRisk['Laki-laki'] + genderRisk.Perempuan > 0) {
                    new Chart(genderCanvas.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ['Laki-laki', 'Perempuan'],
                            datasets: [{
                                label: 'Beresiko Stroke',
                                data: [genderRisk['Laki-laki'], genderRisk.Perempuan],
                                backgroundColor: 'rgba(153, 102, 255, 0.8)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true, grid: { display: false }, title: { display: true, text: 'Jumlah' } },
                                x: { grid: { display: false } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                const topVariablesCanvas = document.getElementById('topVariablesChart');
                if (topVariablesCanvas && Object.keys(topVariables).length > 0) {
                    new Chart(topVariablesCanvas.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: Object.keys(topVariables),
                            datasets: [{
                                label: 'Pengaruh (Rata-rata)',
                                data: Object.values(topVariables),
                                backgroundColor: 'rgba(255, 159, 64, 0.8)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: { beginAtZero: true, grid: { display: false }, title: { display: true, text: 'Nilai Rata-rata' } },
                                y: { grid: { display: false } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection