@extends('admin.dashboard-admin')

@section('title', 'Data Visualisasi')

@section('content')
<div id="content">

    <!-- Begin Page Content -->
    <div class="container-fluid mt-4"> {{-- Ditambahkan mt-4 untuk margin top --}}

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
                    <p class="mb-0"><strong>Dasar:</strong> Heatmap digunakan untuk memvisualisasikan matriks data, di mana intensitas warna mewakili nilai. Dalam kasus ini, intensitas warna menunjukkan kekuatan korelasi.</p>
                    <p class="mb-0"><strong>Penjelasan:</strong> Heatmap ini menunjukkan seberapa kuat hubungan antara variabel-variabel numerik dalam data latih. Warna yang lebih gelap (biru untuk korelasi positif kuat, merah untuk negatif kuat) menunjukkan hubungan yang lebih erat. Angka di dalam kotak adalah nilai korelasinya, berkisar dari -1 (sangat berkebalikan) hingga 1 (sangat searah). Ini membantu mengidentifikasi variabel mana yang mungkin saling mempengaruhi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- End of Main Content -->

</div>

<scr
@endsection