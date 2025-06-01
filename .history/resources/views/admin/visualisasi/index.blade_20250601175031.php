@extends('admin.dashboard-admin')

@section('title', 'Data Visualisasi')

@section('content')
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid mt-4"> {{-- Ditambahkan mt-4 untuk margin top --}}

            <h1 class="h3 mb-2 text-gray-800">Visualisasi Data Latih Machine Learning</h1>
            <p class="mb-4">Bagian ini menampilkan berbagai grafik yang memvisualisasikan karakteristik dan hubungan antar
                variabel dalam data yang digunakan untuk melatih model Machine Learning.</p>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">1. Distribusi Kasus Stroke</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="strokeDistributionChart"></canvas>
                        </div>
                        <div class="card-footer text-muted small text-center">
                            <p class="mb-0"><strong>Dasar:</strong> Grafik batang ini cocok untuk membandingkan jumlah
                                data antar kategori diskrit (Stroke vs. Tidak Stroke).</p>
                            <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini menunjukkan berapa banyak pasien dalam
                                data latih yang tercatat mengalami stroke dan berapa banyak yang tidak. Ini penting untuk
                                memahami keseimbangan data yang digunakan untuk melatih model.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">2. Persentase Jenis Kelamin yang Berisiko Stroke
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="genderStrokeRiskChart"></canvas>
                        </div>
                        <div class="card-footer text-muted small text-center">
                            <p class="mb-0"><strong>Dasar:</strong> Diagram lingkaran (pie chart) efektif untuk
                                menunjukkan proporsi bagian dari keseluruhan.</p>
                            <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini menampilkan persentase pasien
                                laki-laki dan perempuan yang tercatat mengalami stroke dalam data latih. Ini membantu
                                melihat perbandingan risiko stroke antar jenis kelamin.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">3. Tingkat Kejadian Stroke per Kelompok Usia</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="ageStrokeIncidenceChart"></canvas>
                        </div>
                        <div class="card-footer text-muted small text-center">
                            <p class="mb-0"><strong>Dasar:</strong> Grafik garis (line chart) sangat baik untuk
                                menunjukkan tren atau perubahan nilai secara kontinu seiring bertambahnya usia.</p>
                            <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini menunjukkan persentase kejadian stroke
                                untuk setiap kelompok usia dalam data latih. Anda dapat melihat bagaimana risiko stroke
                                cenderung meningkat seiring bertambahnya usia.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">4. Rata-rata BMI Pasien Stroke vs. Non-Stroke</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="bmiStrokeComparisonChart"></canvas>
                        </div>
                        <div class="card-footer text-muted small text-center">
                            <p class="mb-0"><strong>Dasar:</strong> Grafik batang (bar chart) cocok untuk membandingkan
                                nilai rata-rata antara dua kategori yang berbeda.</p>
                            <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini membandingkan rata-rata Indeks Massa
                                Tubuh (BMI) antara pasien yang mengalami stroke dan yang tidak. Ini dapat memberikan wawasan
                                tentang hubungan antara BMI dan risiko stroke.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">5. Rata-rata BMI Berdasarkan Tipe Pekerjaan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="avgBmiWorkTypeChart"></canvas>
                        </div>
                        <div class="card-footer text-muted small text-center">
                            <p class="mb-0"><strong>Dasar:</strong> Grafik garis (line chart) atau batang (bar chart)
                                dapat digunakan untuk menunjukkan tren atau perbandingan nilai rata-rata antar kategori.</p>
                            <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini menampilkan rata-rata Indeks Massa
                                Tubuh (BMI) untuk setiap tipe pekerjaan yang ada dalam data latih. Ini dapat membantu
                                mengidentifikasi apakah ada perbedaan BMI yang signifikan antar kelompok pekerjaan.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">6. Heatmap Korelasi Antar Variabel Numerik</h6>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-start"> {{-- Tambahkan d-flex untuk layout heatmap dan legenda --}}
                            <div id="correlationHeatmap" class="table-responsive flex-grow-1"></div> {{-- flex-grow-1 agar tabel mengambil ruang yang tersedia --}}
                            <div class="correlation-legend ms-3"> {{-- ms-3 untuk margin kiri --}}
                                <div class="legend-scale"></div>
                                <div class="legend-labels d-flex flex-column justify-content-between h-100">
                                    <span>1 (Korelasi Sangat Positif)</span>
                                    <span>0 (Tidak Ada Korelasi)</span>
                                    <span>-1 (Korelasi Sangat Negatif)</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted small text-center">
                            <p class="mb-0"><strong>Dasar:</strong> Heatmap digunakan untuk memvisualisasikan matriks
                                data, di mana intensitas warna mewakili nilai. Dalam kasus ini, intensitas warna menunjukkan
                                kekuatan korelasi.</p>
                            <p class="mb-0"><strong>Penjelasan:</strong> Heatmap ini menunjukkan seberapa kuat hubungan
                                antara variabel-variabel numerik dalam data latih. Warna yang lebih gelap (biru untuk
                                korelasi positif kuat, merah untuk negatif kuat) menunjukkan hubungan yang lebih erat. Angka
                                di dalam kotak adalah nilai korelasinya, berkisar dari -1 (sangat berkebalikan) hingga 1
                                (sangat searah). Ini membantu mengidentifikasi variabel mana yang mungkin saling
                                mempengaruhi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* CSS untuk Legenda Heatmap */
        .correlation-legend {
            display: flex;
            flex-direction: column;
            height: 200px; /* Sesuaikan tinggi legenda agar sesuai dengan tabel */
            margin-left: 15px;
            font-size: 0.85rem;
            justify-content: space-between; /* Untuk menempatkan label di ujung */
        }

        .legend-scale {
            width: 20px; /* Lebar gradien */
            height: 100%;
            /* Gradien dari Biru (-1) ke Putih (0) ke Merah (1) */
            background: linear-gradient(to top, #0000FF, #FFFFFF, #FF0000);
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .legend-labels {
            padding-left: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%; /* Memastikan label mengisi tinggi yang sama dengan skala */
        }
    </style>
    <script>
        // Data dari Controller PHP yang di-encode ke JSON
        const strokeCounts = {!! json_encode($strokeCounts) !!};
        const genderStrokeCounts = {!! json_encode($genderStrokeCounts) !!};
        const ageGroupLabelsForChart = {!! json_encode($ageGroupLabelsForChart) !!};
        const strokeIncidencePerAgeGroup = {!! json_encode($strokeIncidencePerAgeGroup) !!};
        const avgBmiStroke = {!! json_encode($avgBmiStroke) !!};
        const avgBmiNoStroke = {!! json_encode($avgBmiNoStroke) !!};
        const workTypeLabels = {!! json_encode($workTypeLabels) !!};
        const avgBmiPerWorkType = {!! json_encode($avgBmiPerWorkType) !!};
        const correlationMatrix = {!! json_encode($correlationMatrix) !!};
        const numericColumns = {!! json_encode($numericColumns) !!};

        // --- Fungsi untuk mendapatkan warna berdasarkan nilai korelasi ---
        function getColorForCorrelation(value) {
            // Pastikan nilai di antara -1 dan 1
            value = Math.max(-1, Math.min(1, value));

            let r, g, b;

            if (value < 0) {
                // Interpolasi dari Biru (0,0,255) ke Putih (255,255,255)
                // Ketika value dari -1 ke 0, normalizedValue dari 0 ke 0.5
                const normalizedValue = (value + 1) / 2; // -1 -> 0, 0 -> 0.5
                r = Math.floor(255 * normalizedValue / 0.5); // 0 -> 255
                g = Math.floor(255 * normalizedValue / 0.5); // 0 -> 255
                b = 255;
            } else {
                // Interpolasi dari Putih (255,255,255) ke Merah (255,0,0)
                // Ketika value dari 0 ke 1, normalizedValue dari 0.5 ke 1
                const normalizedValue = value / 1; // 0 -> 1
                r = 255;
                g = Math.floor(255 * (1 - normalizedValue)); // 255 -> 0
                b = Math.floor(255 * (1 - normalizedValue)); // 255 -> 0
            }

            return `rgb(${r}, ${g}, ${b})`;
        }


        // --- Chart 1: Distribusi Kasus Stroke (Bar Chart) ---
        const strokeDistributionCanvas = document.getElementById('strokeDistributionChart');
        if (strokeDistributionCanvas) {
            new Chart(strokeDistributionCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Tidak Stroke', 'Stroke'],
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: [strokeCounts[0], strokeCounts[1]],
                        backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)'],
                        borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0,
                            grid: { display: false }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // --- Chart 2: Persentase Jenis Kelamin yang Berisiko Stroke (Pie Chart) ---
        const genderStrokeRiskCanvas = document.getElementById('genderStrokeRiskChart');
        if (genderStrokeRiskCanvas) {
            new Chart(genderStrokeRiskCanvas.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Perempuan Stroke', 'Laki-laki Stroke'],
                    datasets: [{
                        label: 'Jumlah Pasien Stroke',
                        data: [genderStrokeCounts['Perempuan'], genderStrokeCounts['Laki-laki']],
                        backgroundColor: ['rgba(255, 192, 203, 0.8)', 'rgba(54, 162, 235, 0.8)'],
                        borderColor: ['rgba(255, 192, 203, 1)', 'rgba(54, 162, 235, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + ' (' + context.percent.toFixed(2) + '%)';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // --- Chart 3: Tingkat Kejadian Stroke per Kelompok Usia (Line Chart) ---
        const ageStrokeIncidenceCanvas = document.getElementById('ageStrokeIncidenceChart');
        if (ageStrokeIncidenceCanvas) {
            new Chart(ageStrokeIncidenceCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ageGroupLabelsForChart,
                    datasets: [{
                        label: 'Persentase Kejadian Stroke',
                        data: strokeIncidencePerAgeGroup,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100, // Maksimal 100%
                            title: {
                                display: true,
                                text: 'Persentase Kejadian Stroke (%)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                },
                                precision: 0
                            },
                            grid: { display: false }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Kelompok Usia'
                            },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: true },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + '%';
                                }
                            }
                        }
                    }
                }
            });
        }

        // --- Chart 4: Rata-rata BMI Pasien Stroke vs. Non-Stroke (Bar Chart) ---
        const bmiStrokeComparisonCanvas = document.getElementById('bmiStrokeComparisonChart');
        if (bmiStrokeComparisonCanvas) {
            new Chart(bmiStrokeComparisonCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Tidak Stroke', 'Stroke'],
                    datasets: [{
                        label: 'Rata-rata BMI',
                        data: [avgBmiNoStroke, avgBmiStroke],
                        backgroundColor: ['rgba(100, 149, 237, 0.8)', 'rgba(255, 69, 0, 0.8)'], // CornflowerBlue vs Red Orange
                        borderColor: ['rgba(100, 149, 237, 1)', 'rgba(255, 69, 0, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Rata-rata BMI'
                            },
                            grid: { display: false },
                            ticks: { precision: 2 } // BMI bisa desimal
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // --- Chart 5: Rata-rata BMI Berdasarkan Tipe Pekerjaan (Line Chart) ---
        const avgBmiWorkTypeCanvas = document.getElementById('avgBmiWorkTypeChart');
        if (avgBmiWorkTypeCanvas) {
            new Chart(avgBmiWorkTypeCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: workTypeLabels,
                    datasets: [{
                        label: 'Rata-rata BMI',
                        data: avgBmiPerWorkType,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Rata-rata BMI'
                            },
                            grid: { display: false },
                            ticks: { precision: 2 }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tipe Pekerjaan'
                            },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: true },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    }
                }
            });
        }

        // --- Chart 6: Heatmap Korelasi Antar Variabel Numerik ---
        const heatmapContainer = document.getElementById('correlationHeatmap');
        if (heatmapContainer) {
            let heatmapHTML = '<table class="table table-bordered table-sm text-center" style="min-width: 600px;">';
            heatmapHTML += '<thead><tr><th></th>';
            numericColumns.forEach(col => {
                heatmapHTML += `<th>${col.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())}</th>`;
            });
            heatmapHTML += '</tr></thead><tbody>';

            numericColumns.forEach(rowCol => {
                heatmapHTML += `<tr><th>${rowCol.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())}</th>`;
                numericColumns.forEach(colCol => {
                    let correlation = correlationMatrix[rowCol][colCol];
                    let bgColor = '';
                    let textColor = 'text-dark';

                    if (correlation !== null) {
                        bgColor = getColorForCorrelation(correlation);
                        const r = parseInt(bgColor.substring(4, bgColor.indexOf(',')));
                        const g = parseInt(bgColor.substring(bgColor.indexOf(',') + 1, bgColor.lastIndexOf(',')));
                        const b = parseInt(bgColor.substring(bgColor.lastIndexOf(',') + 1, bgColor.length - 1));
                        const brightness = (r * 299 + g * 587 + b * 114) / 1000;
                        textColor = (brightness > 180) ? 'text-dark' : 'text-white';
                    } else {
                        bgColor = 'rgb(108, 117, 125)';
                        textColor = 'text-white';
                        correlation = 'N/A';
                    }

                    heatmapHTML += `<td style="background-color: ${bgColor};" class="${textColor}">${correlation}</td>`;
                });
                heatmapHTML += '</tr>';
            });
            heatmapHTML += '</tbody></table>';
            heatmapContainer.innerHTML = heatmapHTML;
        }
    </script>
@endpush
@endsection
