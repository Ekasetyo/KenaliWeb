@extends('user.dashboard-user')

@section('title', 'Dashboard User')

@section('content')
    <div id="content">
        <div class="container-fluid">

            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard User</h1>
            </div>

            <div class="row">
                <!-- Card untuk Hasil Deteksi -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hasil Deteksi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deteksiCount }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Konsultasi -->
                <div class="col-xl-4 col-md-6 mb-4">
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

            <!-- Chart untuk Hasil Deteksi per Bulan -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-success">Hasil Deteksi per Bulan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="deteksiChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart untuk Konsultasi Per Bulan -->
                <div class="col-lg-6 mb-4">
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

            <!-- Chart untuk Persentase Risiko Stroke Berdasarkan Jenis Kelamin -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Persentase Risiko Stroke Berdasarkan Jenis Kelamin</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const deteksiPerMonth = {!! json_encode($deteksisPerMonth) !!};
            const konsultasiPerMonth = {!! json_encode($konsultasiPerMonth) !!}.map(num => Math.floor(num));
            const genderCounts = {!! json_encode($genderCounts) !!};
            const ageRiskData = {!! json_encode($ageRiskData) !!};

            // Chart untuk Hasil Deteksi per Bulan
            const deteksiCanvas = document.getElementById('deteksiChart');
            if (deteksiCanvas) {
                new Chart(deteksiCanvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Hasil Deteksi',
                            data: deteksiPerMonth,
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true },
                            x: { title: { display: true, text: 'Bulan' } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // Chart untuk Konsultasi Per Bulan
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
                            y: { beginAtZero: true },
                            x: { title: { display: true, text: 'Bulan' } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // Chart untuk Persentase Risiko Stroke Berdasarkan Jenis Kelamin (Pie Chart)
            const genderCanvas = document.getElementById('genderChart');
            if (genderCanvas) {
                new Chart(genderCanvas.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: Object.keys(genderCounts),
                        datasets: [{
                            label: 'Jumlah Pasien',
                            data: Object.values(genderCounts),
                            backgroundColor: ['rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)'],
                            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Persentase Risiko Stroke Berdasarkan Jenis Kelamin'
                            }
                        }
                    }
                });
            }


            const ageRiskCanvas = document.getElementById('ageRiskChart');
        if (ageRiskCanvas) {
            new Chart(ageRiskCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: Array.from({length: 101}, (_, i) => i), // Usia dari 0 sampai 100
                    datasets: [{
                        label: 'Risiko Stroke',
                        data: ageRiskData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true },
                        x: { title: { display: true, text: 'Usia (Tahun)' } }
                    },
                    plugins: {
                        legend: {
                            display: true,
                        },
                        title: {
                            display: true,
                            text: 'Risiko Stroke Berdasarkan Usia'
                        }
                    }
                }
            });
        }
        </script>
    @endpush
@endsection
