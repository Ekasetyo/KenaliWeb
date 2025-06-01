@extends('user.dashboard-user')

@section('title', 'Dashboard Pengguna')

@section('content')
    <div id="content">
        <div class="container-fluid">

            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard Pengguna</h1>
            </div>

            <div class="row">
                <!-- Hasil Deteksi Card -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Hasil Deteksi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deteksiCount }}</div>
                                    <div class="text-xs font-weight-bold text-gray-500">Beresiko: {{ $deteksiRisk['Beresiko'] }}</div>
                                    <div class="text-xs font-weight-bold text-gray-500">Tidak Beresiko: {{ $deteksiRisk['Tidak Beresiko'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konsultasi Card -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Konsultasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $konsultasiCount }}</div>
                                    <p class="text-xs font-weight-bold text-gray-500">Konsultasi per Hari:</p>
                                    <ul>
                                        @foreach ($konsultasiPerDay as $day => $count)
                                            <li>Hari {{ $day + 1 }}: {{ $count }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row -->
            <div class="row">
                <!-- Chart for Konsultasi Per Day -->
                <div class="col-lg-12 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Konsultasi per Hari (Bulan Ini)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="konsultasiChart"></canvas>
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
                const konsultasiPerDay = {!! json_encode($konsultasiPerDay) !!};

                const konsultasiCanvas = document.getElementById('konsultasiChart');
                if (konsultasiCanvas) {
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
                                legend: { display: true },
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
            });
        </script>
    @endpush
@endsection