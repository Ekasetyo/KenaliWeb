@extends('admin.dashboard-admin')

@section('title', 'Visualisasi Data')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="h3 mb-2 text-gray-800">Visualisasi Data Latih Machine Learning</h1>
    <p class="mb-4">Bagian ini menampilkan berbagai grafik yang memvisualisasikan karakteristik dan hubungan antar variabel dalam data yang digunakan untuk melatih model Machine Learning.</p>

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
                    <p class="mb-0"><strong>Dasar:</strong> Grafik batang ini cocok untuk membandingkan jumlah data antar kategori diskrit (Stroke vs. Tidak Stroke).</p>
                    <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini menunjukkan berapa banyak pasien dalam data latih yang tercatat mengalami stroke dan berapa banyak yang tidak. Ini penting untuk memahami keseimbangan data yang digunakan untuk melatih model.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">2. Proporsi Jenis Kelamin Pasien</h6>
                </div>
                <div class="card-body">
                    <canvas id="genderProportionChart"></canvas>
                </div>
                <div class="card-footer text-muted small text-center">
                    <p class="mb-0"><strong>Dasar:</strong> Diagram lingkaran (pie chart) sangat baik untuk menunjukkan proporsi bagian dari keseluruhan.</p>
                    <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini memperlihatkan perbandingan persentase jumlah pasien laki-laki dan perempuan yang ada di dalam data latih. Ini memberikan gambaran tentang representasi gender dalam data.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">3. Distribusi Usia Pasien</h6>
                </div>
                <div class="card-body">
                    <canvas id="ageDistributionChart"></canvas>
                </div>
                <div class="card-footer text-muted small text-center">
                    <p class="mb-0"><strong>Dasar:</strong> Histogram (disimulasikan dengan bar chart) digunakan untuk menunjukkan distribusi frekuensi dari variabel numerik kontinu.</p>
                    <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini menunjukkan bagaimana usia pasien tersebar dalam data latih. Batang-batang menunjukkan kelompok usia, dan tinggi batang menunjukkan berapa banyak pasien yang berada dalam kelompok usia tersebut.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">4. Hubungan Usia dan Rata-rata Kadar Glukosa</h6>
                </div>
                <div class="card-body">
                    <canvas id="ageGlucoseScatterChart"></canvas>
                </div>
                <div class="card-footer text-muted small text-center">
                    <p class="mb-0"><strong>Dasar:</strong> Diagram sebar (scatter plot) ideal untuk memvisualisasikan hubungan antara dua variabel numerik.</p>
                    <p class="mb-0"><strong>Penjelasan:</strong> Setiap titik pada grafik ini mewakili satu pasien. Posisi horizontal titik menunjukkan usia pasien, dan posisi vertikal menunjukkan rata-rata kadar glukosa mereka. Ini bisa membantu melihat apakah ada pola atau hubungan antara usia dan kadar glukosa.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">5. Hubungan Status Merokok dan Kejadian Stroke berdasarkan Jenis Kelamin</h6>
                </div>
                <div class="card-body">
                    <canvas id="smokingGenderStrokeChart"></canvas>
                </div>
                <div class="card-footer text-muted small text-center">
                    <p class="mb-0"><strong>Dasar:</strong> Grafik batang bertumpuk (stacked bar chart) cocok untuk membandingkan komposisi kategori dalam kelompok yang berbeda.</p>
                    <p class="mb-0"><strong>Penjelasan:</strong> Grafik ini menunjukkan jumlah pasien berdasarkan status merokok mereka dan apakah mereka mengalami stroke atau tidak, yang kemudian dibagi lagi berdasarkan jenis kelamin. Ini membantu melihat pola hubungan antara kebiasaan merokok, jenis kelamin, dan risiko stroke.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">6. Heatmap Korelasi Antar Variabel Numerik</h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-start">
                    <div id="correlationHeatmap" class="table-responsive flex-grow-1"></div>
                    <div class="correlation-legend ms-3">
                        <div class="legend-scale"></div>
                        <div class="legend-labels d-flex flex-column justify-content-between h-100">
                            <span>1 (Korelasi Sangat Positif)</span>
                            <span>0 (Tidak Ada Korelasi)</span>
                            <span>-1 (Korelasi Sangat Negatif)</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted small text-center">
                    <p class="mb-0"><strong>Dasar:</strong> Heatmap digunakan untuk memvisualisasikan matriks data, di mana intensitas warna mewakili nilai. Dalam kasus ini, intensitas warna menunjukkan kekuatan korelasi.</p>
                    <p class="mb-0"><strong>Penjelasan:</strong> Heatmap ini menunjukkan seberapa kuat hubungan antara variabel-variabel numerik dalam data latih. Warna yang lebih gelap (biru untuk korelasi positif kuat, merah untuk negatif kuat) menunjukkan hubungan yang lebih erat. Angka di dalam kotak adalah nilai korelasinya, berkisar dari -1 (sangat berkebalikan) hingga 1 (sangat searah). Ini membantu mengidentifikasi variabel mana yang mungkin saling mempengaruhi.</p>
                </div>
            </div>
        </div>
    </div>
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
        const genderCounts = {!! json_encode($genderCounts) !!};
        const ageDataRaw = {!! json_encode($ageDataRaw) !!};
        const ageGlucoseData = {!! json_encode($ageGlucoseData) !!};
        const smokingLabels = {!! json_encode($smokingLabels) !!};
        const lakiLakiStroke = {!! json_encode($lakiLakiStroke) !!};
        const lakiLakiNoStroke = {!! json_encode($lakiLakiNoStroke) !!};
        const perempuanStroke = {!! json_encode($perempuanStroke) !!};
        const perempuanNoStroke = {!! json_encode($perempuanNoStroke) !!};
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
                            precision: 0, // Pastikan tidak ada desimal
                            grid: { display: false } // Menghilangkan garis grid
                        },
                        x: {
                            grid: { display: false } // Menghilangkan garis grid
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // --- Chart 2: Proporsi Jenis Kelamin (Pie Chart) ---
        const genderProportionCanvas = document.getElementById('genderProportionChart');
        if (genderProportionCanvas) {
            new Chart(genderProportionCanvas.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Perempuan', 'Laki-laki'],
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: [genderCounts[0], genderCounts[1]],
                        backgroundColor: ['rgba(255, 192, 203, 0.8)', 'rgba(54, 162, 235, 0.8)'], // Warna berbeda
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
                                // Menampilkan persentase pada tooltip
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

        // --- Chart 3: Distribusi Usia Pasien (Histogram/Bar Chart) ---
        const ageDistributionCanvas = document.getElementById('ageDistributionChart');
        if (ageDistributionCanvas) {
            const ageBins = {};
            // Mengelompokkan usia ke dalam bin 10 tahun (misal: 0-9, 10-19, dst.)
            for (const age of ageDataRaw) {
                const binStart = Math.floor(age / 10) * 10;
                const binEnd = binStart + 9;
                const binLabel = `${binStart}-${binEnd}`;
                ageBins.hasOwnProperty(binLabel) ? ageBins[binLabel]++ : ageBins[binLabel] = 1;
            }
            // Mengurutkan label usia agar tampil berurutan
            const ageLabels = Object.keys(ageBins).sort((a, b) => {
                const startA = parseInt(a.split('-')[0]);
                const startB = parseInt(b.split('-')[0]);
                return startA - startB;
            });
            const ageCounts = ageLabels.map(label => ageBins[label]);

            new Chart(ageDistributionCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ageLabels,
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: ageCounts,
                        backgroundColor: 'rgba(153, 102, 255, 0.8)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0, // Pastikan tidak ada desimal
                            grid: { display: false } // Menghilangkan garis grid
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Rentang Usia'
                            },
                            grid: { display: false } // Menghilangkan garis grid
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // --- Chart 4: Hubungan Usia dan Rata-rata Kadar Glukosa (Scatter Plot) ---
        const ageGlucoseScatterCanvas = document.getElementById('ageGlucoseScatterChart');
        if (ageGlucoseScatterCanvas) {
            new Chart(ageGlucoseScatterCanvas.getContext('2d'), {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Kadar Glukosa vs. Usia',
                        data: ageGlucoseData,
                        backgroundColor: 'rgba(255, 206, 86, 0.8)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            title: {
                                display: true,
                                text: 'Usia (Tahun)'
                            },
                            grid: { display: false } // Menghilangkan garis grid
                        },
                        y: {
                            type: 'linear',
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Rata-rata Kadar Glukosa'
                            },
                            grid: { display: false } // Menghilangkan garis grid
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // --- Chart 5: Hubungan Merokok dan Stroke per Jenis Kelamin (Stacked Bar Chart) ---
        const smokingGenderStrokeCanvas = document.getElementById('smokingGenderStrokeChart');
        if (smokingGenderStrokeCanvas) {
            new Chart(smokingGenderStrokeCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: smokingLabels,
                    datasets: [{
                        label: 'Laki-laki (Stroke)',
                        data: lakiLakiStroke,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)', // Biru gelap
                    }, {
                        label: 'Laki-laki (Tidak Stroke)',
                        data: lakiLakiNoStroke,
                        backgroundColor: 'rgba(54, 162, 235, 0.4)', // Biru muda
                    }, {
                        label: 'Perempuan (Stroke)',
                        data: perempuanStroke,
                        backgroundColor: 'rgba(255, 99, 132, 0.8)', // Merah gelap
                    }, {
                        label: 'Perempuan (Tidak Stroke)',
                        data: perempuanNoStroke,
                        backgroundColor: 'rgba(255, 99, 132, 0.4)', // Merah muda
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true, // Batang bertumpuk
                            title: { display: true, text: 'Status Merokok' },
                            grid: { display: false } // Menghilangkan garis grid
                        },
                        y: {
                            stacked: true, // Batang bertumpuk
                            beginAtZero: true,
                            precision: 0, // Pastikan tidak ada desimal
                            title: { display: true, text: 'Jumlah Pasien' },
                            grid: { display: false } // Menghilangkan garis grid
                        }
                    },
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        // --- Chart 6: Heatmap Korelasi Antar Variabel Numerik ---
        const heatmapContainer = document.getElementById('correlationHeatmap');
        if (heatmapContainer) {
            let heatmapHTML = '<table class="table table-bordered table-sm text-center" style="min-width: 600px;">';
            heatmapHTML += '<thead><tr><th></th>';
            // Membuat header kolom
            numericColumns.forEach(col => {
                // Memformat nama kolom agar lebih mudah dibaca (misal: avg_glucose_level -> Avg Glucose Level)
                heatmapHTML += `<th>${col.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())}</th>`;
            });
            heatmapHTML += '</tr></thead><tbody>';

            // Mengisi baris dan sel tabel
            numericColumns.forEach(rowCol => {
                heatmapHTML += `<tr><th>${rowCol.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())}</th>`;
                numericColumns.forEach(colCol => {
                    let correlation = correlationMatrix[rowCol][colCol];
                    let bgColor = '';
                    let textColor = 'text-dark'; // Warna teks default

                    if (correlation !== null) {
                        bgColor = getColorForCorrelation(correlation); // Menggunakan fungsi warna baru
                        // Tentukan warna teks berdasarkan kecerahan warna latar belakang
                        // Ini adalah perkiraan sederhana, untuk akurasi lebih baik bisa pakai perhitungan luminansi
                        const r = parseInt(bgColor.substring(4, bgColor.indexOf(',')));
                        const g = parseInt(bgColor.substring(bgColor.indexOf(',') + 1, bgColor.lastIndexOf(',')));
                        const b = parseInt(bgColor.substring(bgColor.lastIndexOf(',') + 1, bgColor.length - 1));
                        const brightness = (r * 299 + g * 587 + b * 114) / 1000;
                        textColor = (brightness > 180) ? 'text-dark' : 'text-white'; // Jika terang, pakai teks gelap; jika gelap, pakai teks terang
                    } else {
                        bgColor = 'rgb(108, 117, 125)'; // Warna abu-abu untuk N/A
                        textColor = 'text-white';
                        correlation = 'N/A'; // Tampilkan N/A jika korelasi tidak tersedia
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
