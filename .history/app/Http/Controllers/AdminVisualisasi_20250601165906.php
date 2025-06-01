<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminVisualisasi extends Controller
{
    /**
     * Menampilkan halaman visualisasi data untuk admin.
     * Mengambil dan mengolah data dari koleksi 'data_stroke' di MongoDB
     * untuk ditampilkan dalam berbagai grafik.
     */
    public function visualisasi()
    {
        // Ambil semua data dari koleksi 'data_stroke'
        // Menggunakan find([]) tanpa kriteria untuk mengambil semua dokumen
        $allData = DB::connection('mongodb')->selectCollection('data_stroke')->find([])->toArray();

        // --- 1. Data untuk Distribusi Kasus Stroke (Bar Chart) ---
        // Menghitung jumlah pasien yang mengalami stroke (1) dan tidak (0)
        $strokeCounts = [0 => 0, 1 => 0]; // Inisialisasi hitungan
        foreach ($allData as $item) {
            // Memastikan properti 'stroke' ada dan mengkonversinya ke integer
            if (isset($item->stroke)) {
                $strokeCounts[(int)$item->stroke]++;
            }
        }

        // --- 2. Data untuk Proporsi Jenis Kelamin (Pie Chart) ---
        // Menghitung jumlah pasien berdasarkan jenis kelamin (0: Perempuan, 1: Laki-laki)
        $genderCounts = [0 => 0, 1 => 0]; // Inisialisasi hitungan
        foreach ($allData as $item) {
            // Memastikan properti 'sex' ada dan mengkonversinya ke integer
            if (isset($item->sex)) {
                $genderCounts[(int)$item->sex]++;
            }
        }

        // --- 3. Data untuk Distribusi Usia Pasien (Histogram/Bar Chart) ---
        // Mengambil semua nilai usia mentah
        $ageDataRaw = [];
        foreach ($allData as $item) {
            // Memastikan properti 'age' ada dan mengkonversinya ke float
            if (isset($item->age)) {
                $ageDataRaw[] = (float)$item->age;
            }
        }

        // --- 4. Data untuk Hubungan Usia dan Rata-rata Kadar Glukosa (Scatter Plot) ---
        // Mengambil pasangan data usia dan kadar glukosa
        $ageGlucoseData = [];
        foreach ($allData as $item) {
            // Memastikan properti 'age' dan 'avg_glucose_level' ada dan mengkonversinya ke float
            if (isset($item->age) && isset($item->avg_glucose_level)) {
                $ageGlucoseData[] = ['x' => (float)$item->age, 'y' => (float)$item->avg_glucose_level];
            }
        }

        // --- 5. Data untuk Hubungan Merokok dan Stroke per Jenis Kelamin (Stacked Bar Chart) ---
        // Mapping status merokok dari angka ke label yang mudah dibaca
        $smokingStatusMap = [
            0 => 'Tidak Diketahui', // Sesuai contoh data
            1 => 'Tidak Pernah Merokok',
            2 => 'Dulu Merokok',
            3 => 'Merokok'
        ];
        // Inisialisasi struktur data untuk menyimpan hitungan
        $smokingGenderStrokeData = [
            'Laki-laki' => [],
            'Perempuan' => []
        ];
        // Inisialisasi hitungan untuk setiap status merokok di setiap jenis kelamin
        foreach ($smokingStatusMap as $key => $label) {
            $smokingGenderStrokeData['Laki-laki'][$label] = ['stroke' => 0, 'noStroke' => 0];
            $smokingGenderStrokeData['Perempuan'][$label] = ['stroke' => 0, 'noStroke' => 0];
        }

        // Mengisi data berdasarkan iterasi semua data pasien
        foreach ($allData as $item) {
            // Memastikan properti yang dibutuhkan ada
            if (isset($item->sex) && isset($item->smoking_status) && isset($item->stroke)) {
                // Menentukan jenis kelamin
                $gender = ((int)$item->sex === 1) ? 'Laki-laki' : 'Perempuan';
                // Menentukan status merokok berdasarkan mapping
                $smokingStatus = $smokingStatusMap[(int)$item->smoking_status] ?? 'Tidak Diketahui';
                // Menentukan status stroke
                $strokeStatus = ((int)$item->stroke === 1) ? 'stroke' : 'noStroke';

                // Menambahkan hitungan ke struktur data yang sesuai
                if (isset($smokingGenderStrokeData[$gender][$smokingStatus])) {
                    $smokingGenderStrokeData[$gender][$smokingStatus][$strokeStatus]++;
                }
            }
        }

        // Memisahkan data untuk Chart.js menjadi beberapa dataset
        $smokingLabels = array_values($smokingStatusMap); // Label untuk sumbu X
        $lakiLakiStroke = [];
        $lakiLakiNoStroke = [];
        $perempuanStroke = [];
        $perempuanNoStroke = [];

        // Mengisi array data untuk setiap dataset
        foreach ($smokingLabels as $label) {
            $lakiLakiStroke[] = $smokingGenderStrokeData['Laki-laki'][$label]['stroke'];
            $lakiLakiNoStroke[] = $smokingGenderStrokeData['Laki-laki'][$label]['noStroke'];
            $perempuanStroke[] = $smokingGenderStrokeData['Perempuan'][$label]['stroke'];
            $perempuanNoStroke[] = $smokingGenderStrokeData['Perempuan'][$label]['noStroke'];
        }


        // --- 6. Data untuk Heatmap Korelasi ---
        // Daftar kolom numerik yang akan dihitung korelasinya
        // Termasuk variabel biner/kategorikal yang diwakili secara numerik
        $numericColumns = [
            'age', 'hypertension', 'heart_disease', 'avg_glucose_level', 'bmi',
            'sex', 'ever_married', 'work_type', 'Residence_type', 'smoking_status', 'stroke'
        ];
        $matrixData = []; // Data dalam format matriks untuk perhitungan korelasi
        foreach ($allData as $item) {
            $row = [];
            foreach ($numericColumns as $col) {
                if (isset($item->$col)) {
                    // Pastikan semua nilai adalah float untuk perhitungan numerik
                    $row[$col] = (float)$item->$col;
                } else {
                    $row[$col] = null; // Menangani data yang hilang
                }
            }
            $matrixData[] = $row;
        }

        // Menghitung matriks korelasi menggunakan fungsi helper
        $correlationMatrix = $this->calculateCorrelationMatrix($matrixData, $numericColumns);


        // Mengirim semua data yang telah diolah ke view
        return view('admin.visualisasi.index', [
            'strokeCounts' => $strokeCounts,
            'genderCounts' => $genderCounts,
            'ageDataRaw' => $ageDataRaw,
            'ageGlucoseData' => $ageGlucoseData,
            'smokingLabels' => $smokingLabels,
            'lakiLakiStroke' => $lakiLakiStroke,
            'lakiLakiNoStroke' => $lakiLakiNoStroke,
            'perempuanStroke' => $perempuanStroke,
            'perempuanNoStroke' => $perempuanNoStroke,
            'correlationMatrix' => $correlationMatrix,
            'numericColumns' => $numericColumns, // Untuk label di heatmap
        ]);
    }

    /**
     * Menghitung koefisien korelasi Pearson antara dua array.
     * @param array $x Array data pertama
     * @param array $y Array data kedua
     * @return float|null Koefisien korelasi atau null jika tidak dapat dihitung
     */
    private function calculatePearsonCorrelation(array $x, array $y): ?float
    {
        $n = count($x);
        // Jika jumlah data nol atau tidak sama, tidak dapat menghitung korelasi
        if ($n === 0 || $n !== count($y)) {
            return null;
        }

        $sum_x = array_sum($x);
        $sum_y = array_sum($y);
        $sum_xy = 0;
        $sum_x2 = 0;
        $sum_y2 = 0;

        // Menghitung komponen untuk rumus korelasi Pearson
        for ($i = 0; $i < $n; $i++) {
            $sum_xy += $x[$i] * $y[$i];
            $sum_x2 += $x[$i] * $x[$i];
            $sum_y2 += $y[$i] * $y[$i];
        }

        $numerator = $n * $sum_xy - $sum_x * $sum_y;
        $denominator = sqrt(($n * $sum_x2 - $sum_x * $sum_x) * ($n * $sum_y2 - $sum_y * $sum_y));

        // Hindari pembagian dengan nol
        if ($denominator == 0) {
            return null;
        }

        return $numerator / $denominator;
    }

    /**
     * Menghitung matriks korelasi untuk data dan kolom yang diberikan.
     * @param array $data Array dari array asosiatif (baris data)
     * @param array $columns List kolom yang akan dihitung korelasinya
     * @return array Matriks korelasi
     */
    private function calculateCorrelationMatrix(array $data, array $columns): array
    {
        $matrix = []; // Matriks hasil korelasi

        // Iterasi untuk setiap pasangan kolom
        foreach ($columns as $col1) {
            $matrix[$col1] = [];
            foreach ($columns as $col2) {
                if ($col1 === $col2) {
                    // Korelasi variabel dengan dirinya sendiri adalah 1
                    $matrix[$col1][$col2] = 1.0;
                } else {
                    // Mengumpulkan data untuk dua kolom yang akan dihitung korelasinya
                    $filteredX = [];
                    $filteredY = [];
                    for ($i = 0; $i < count($data); $i++) {
                        // Hanya sertakan data jika kedua nilai ada (tidak null)
                        if (isset($data[$i][$col1]) && isset($data[$i][$col2])) {
                            $filteredX[] = $data[$i][$col1];
                            $filteredY[] = $data[$i][$col2];
                        }
                    }
                    // Menghitung korelasi Pearson
                    $correlation = $this->calculatePearsonCorrelation($filteredX, $filteredY);
                    // Membulatkan hasil korelasi untuk tampilan, default 0.0 jika null
                    $matrix[$col1][$col2] = $correlation !== null ? round($correlation, 2) : 0.0;
                }
            }
        }
        return $matrix;
    }
}
