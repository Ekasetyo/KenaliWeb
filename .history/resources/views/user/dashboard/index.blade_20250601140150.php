@extends('user.dashboard-user')

@section('title', 'Dashboard Pengguna')

@section('content')
    <div id="content">
        <div class="container-fluid">

            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard Pengguna</h1>
            </div>

            <div class="row">
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hasil Deteksi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deteksiCount }}</div>
                                    <div class="text-xs font-weight-bold text-gray-500">Beresiko: {{ $deteksiRisk['Beresiko'] }}</div>
                                    <div class="text-xs font-weight-bold text-gray-500">Tidak Beresiko: {{ $deteksiRisk['Tidak Beresiko'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Konsultasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $konsultasiCount }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Chart untuk Konsultasi Per Bulan -->
                <div class="col-lg-12 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-warning">Konsultasi per Bulan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="konsultasiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const konsultasiPerMonth = {!! json_encode($konsultasiPerMonth) !!};

            const konsultasiCanvas = document.getElementById('konsultasiChart');
            if (konsultasiCanvas) {
                new Chart(konsultasiCanvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Konsultasi',
                            data: konsultasiPerMonth,
                            backgroundColor: 'rgba(255, 159, 64, 0.8)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, grid: { display: false } },
                            x: { grid: { display: false }, title: { display: true, text: 'Bulan' } }
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
        </script>
    @endpush
@endsection