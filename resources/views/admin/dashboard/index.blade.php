@extends('admin.dashboard-admin')

@section('title', 'Dashboard Admin')

@section('content')
<div id="content">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- User Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Artikel Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Artikel</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $artikelCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deteksi Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Deteksi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deteksiCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-search fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Chart Row -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">User per Bulan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Artikel per Bulan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="artikelChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-success">Deteksi per Bulan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="deteksiChart"></canvas>
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
    const usersPerMonth = {!! json_encode($usersPerMonthArray) !!};
    const artikelsPerMonth = {!! json_encode($artikelsPerMonthArray) !!};
    const deteksisPerMonth = {!! json_encode($deteksisPerMonthArray) !!};

    // User Chart
    var ctx1 = document.getElementById('userChart').getContext('2d');
    var userChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'User',
                data: usersPerMonth.map(Math.floor),
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 0,
                barThickness: 30,
                hoverBackgroundColor: 'rgba(54, 162, 235, 1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            },
            scales: {
                y: { beginAtZero: true, grid: { display: false }, ticks: { display: false }},
                x: { grid: { display: false }, title: { display: true, text: 'Bulan' }}
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + Math.floor(tooltipItem.raw);
                        }
                    }
                }
            }
        }
    });

    // Artikel Chart
    var ctx2 = document.getElementById('artikelChart').getContext('2d');
    var artikelChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Artikel',
                data: artikelsPerMonth.map(Math.floor),
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 0,
                barThickness: 30,
                hoverBackgroundColor: 'rgba(255, 99, 132, 1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            },
            scales: {
                y: { beginAtZero: true, grid: { display: false }, ticks: { display: false }},
                x: { grid: { display: false }, title: { display: true, text: 'Bulan' }}
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + Math.floor(tooltipItem.raw);
                        }
                    }
                }
            }
        }
    });

    // Deteksi Chart
    var ctx4 = document.getElementById('deteksiChart').getContext('2d');
    var deteksiChart = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Deteksi',
                data: deteksisPerMonth.map(Math.floor),
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 0,
                barThickness: 30,
                hoverBackgroundColor: 'rgba(75, 192, 192, 1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            },
            scales: {
                y: { beginAtZero: true, grid: { display: false }, ticks: { display: false }},
                x: { grid: { display: false }, title: { display: true, text: 'Bulan' }}
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + Math.floor(tooltipItem.raw);
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection